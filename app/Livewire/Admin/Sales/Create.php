<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Enums\MovementType;
use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use App\Jobs\PaymentNotification;
use App\Livewire\Utils\Admin\WithModels;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Movement;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\SalePayment;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.dashboard')]
class Create extends Component
{
    use LivewireAlert;
    use WithModels;

    public $cart_instance = 'sale';

    public $global_discount;

    public $discount_amount;

    public $global_tax;

    public $quantity;

    public $check_quantity;

    public $discount_type;

    public $item_discount;

    public $date;

    public $price;

    public $default_client;

    public $default_warehouse;

    #[Rule('required', message: 'Please provide a customer ID')]
    public $customer_id;

    #[Rule('required', message: 'Please provide a warehouse ID')]
    public $warehouse_id;

    #[Rule('required', message: 'Please provide a tax percentage')]
    #[Rule('integer', message: 'The tax percentage must be an integer')]
    #[Rule('min:0', message: 'The tax percentage must be at least 0')]
    #[Rule('max:100', message: 'The tax percentage must not exceed 100')]
    public $tax_percentage;

    #[Rule('required', message: 'Please provide a discount percentage')]
    #[Rule('integer', message: 'The discount percentage must be an integer')]
    #[Rule('min:0', message: 'The discount percentage must be at least 0')]
    #[Rule('max:100', message: 'The discount percentage must not exceed 100')]
    public $discount_percentage;

    #[Rule('nullable', message: 'Shipping amount must be a numeric value')]
    public $shipping_amount;

    #[Rule('required', message: 'Please provide a total amount')]
    #[Rule('numeric', message: 'The total amount must be a numeric value')]
    public $total_amount;

    #[Rule('nullable', message: 'Paid amount must be a numeric value')]
    public $paid_amount;

    #[Rule('nullable', message: 'Note must be a string with a maximum length of 1000')]
    #[Rule('string', message: 'Note must be a string')]
    #[Rule('max:1000', message: 'Note must not exceed 1000 characters')]
    public $note;

    #[Rule('required|integer|max:255')]
    public $status;

    public $payment_method = 'cash';

    public function mount(): void
    {
        abort_if(Gate::denies('sale create'), 403);

        Cart::instance('sale')->destroy();

        // $this->cart_instance = $cartInstance;
        $this->discount_percentage = 0;
        $this->tax_percentage = 0;
        $this->shipping_amount = 0;
        $this->check_quantity = [];
        $this->quantity = [];
        $this->discount_type = [];
        $this->item_discount = [];
        $this->payment_method = 'cash';
        $this->paid_amount = $this->total_amount;

        $this->default_client = Customer::find(settings('default_client_id'));
        $this->default_warehouse = Warehouse::find(settings('default_warehouse_id'));

        $this->date = date('Y-m-d');
    }

    public function hydrate(): void
    {
        if ($this->payment_method === 'cash') {
            $this->paid_amount = $this->total_amount;
        }

        $this->total_amount = $this->calculateTotal();
    }

    public function render()
    {
        $cart_items = Cart::instance($this->cart_instance)->content();

        return view('livewire.admin.sales.create', [
            'cart_items' => $cart_items,
        ]);
    }

    public function proceed(): void
    {
        if ($this->customer_id !== null) {
            $this->store();
        } else {
            $this->alert('error', __('Please select a customer!'));
        }
    }

    public function store(): void
    {
        if ( ! $this->warehouse_id) {
            $this->alert('error', __('Please select a warehouse'));

            return;
        }

        DB::transaction(function () {
            $this->validate();

            // Determine payment status
            $due_amount = $this->total_amount - $this->paid_amount;

            if ($due_amount === $this->total_amount) {
                $payment_status = PaymentStatus::PENDING;
                $this->status = SaleStatus::PENDING;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
                $this->status = SaleStatus::PENDING;
            } else {
                $payment_status = PaymentStatus::PAID;
                $this->status = SaleStatus::COMPLETED;
            }

            $sale = Sale::create([
                'date'                => $this->date,
                'customer_id'         => $this->customer_id,
                'warehouse_id'        => $this->warehouse_id,
                'user_id'             => Auth::user()->id,
                'tax_percentage'      => $this->tax_percentage,
                'discount_percentage' => $this->discount_percentage,
                'shipping_amount'     => $this->shipping_amount * 100,
                'paid_amount'         => $this->paid_amount * 100,
                'total_amount'        => $this->total_amount * 100,
                'due_amount'          => $due_amount * 100,
                'status'              => $this->status,
                'payment_status'      => $payment_status,
                'payment_method'      => $this->payment_method,
                'note'                => $this->note,
                'tax_amount'          => (int) (Cart::instance('sale')->tax() * 100),
                'discount_amount'     => (int) (Cart::instance('sale')->discount() * 100),
            ]);

            // foreach ($this->cart_instance as cart_items) {}
            foreach (Cart::instance('sale')->content() as $cart_item) {
                SaleDetails::create([
                    'sale_id'                 => $sale->id,
                    'warehouse_id'            => $this->warehouse_id,
                    'product_id'              => $cart_item->id,
                    'name'                    => $cart_item->name,
                    'code'                    => $cart_item->options->code,
                    'quantity'                => $cart_item->qty,
                    'price'                   => $cart_item->price * 100,
                    'unit_price'              => $cart_item->options->unit_price * 100,
                    'sub_total'               => $cart_item->options->sub_total * 100,
                    'product_discount_amount' => $cart_item->options->product_discount * 100,
                    'product_discount_type'   => $cart_item->options->product_discount_type,
                    'product_tax_amount'      => $cart_item->options->product_tax * 100,
                ]);

                $product = Product::findOrFail($cart_item->id);
                $product_warehouse = ProductWarehouse::where('product_id', $product->id)
                    ->where('warehouse_id', $this->warehouse_id)
                    ->first();

                $new_quantity = $product_warehouse->qty - $cart_item->qty;

                $product_warehouse->update([
                    'qty' => $new_quantity,
                ]);

                $movement = new Movement([
                    'type'         => MovementType::SALE,
                    'quantity'     => $cart_item->qty,
                    'price'        => $cart_item->price * 100,
                    'date'         => date('Y-m-d'),
                    'movable_type' => $product::class,
                    'movable_id'   => $product->id,
                    'user_id'      => Auth::user()->id,
                ]);

                $movement->save();
            }

            Cart::instance('sale')->destroy();

            if ($this->paid_amount > 0) {
                SalePayment::create([
                    'date'           => date('Y-m-d'),
                    'amount'         => $this->paid_amount * 100,
                    'sale_id'        => $sale->id,
                    'payment_method' => $this->payment_method,
                    'user_id'        => Auth::user()->id,
                ]);
            }

            $this->alert('success', __('Sale created successfully!'));

            Cart::instance('sale')->destroy();

            // dispatch the Send Payment Notification job
            PaymentNotification::dispatch($sale);

            return redirect()->route('admin.sales.index');
        });
    }

    public function calculateTotal(): float|int|array
    {
        return Cart::instance($this->cart_instance)->total() + $this->shipping_amount;
    }

    public function resetCart(): void
    {
        Cart::instance($this->cart_instance)->destroy();
    }

    #[Computed]
    public function category()
    {
        return Category::select('name', 'id')->get();
    }

    public function updatedWarehouseId($value): void
    {
        $this->warehouse_id = $value;
        $this->dispatch('warehouseSelected', $this->warehouse_id);
    }

    public function updatedStatus($value): void
    {
        if ($value === SaleStatus::COMPLETED->value) {
            $this->paid_amount = $this->total_amount;
        }
    }
}
