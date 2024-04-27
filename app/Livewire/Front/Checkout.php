<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Enums\ShippingStatus;
use App\Mail\CheckoutMail;
use App\Mail\CustomerRegistrationMail;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Shipping;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class Checkout extends Component
{
    use LivewireAlert;

    public $listeners = [
        'checkoutCartUpdated' => '$refresh',
        'confirmed',
    ];

    public $payment_method = 'cash';

    public $shipping_amount;

    #[Rule('required')]
    public $name;

    #[Rule('required|email')]
    public $email;

    public $customer;

    #[Rule('required')]
    public $address;

    #[Rule('required')]
    public $city;

    public $country = 'Maroc';

    #[Rule('required|numeric')]
    public $phone;

    public $password;

    public $shipping_id;

    public $cartTotal;

    public $productId;

    public function confirmed(): void
    {
        Cart::instance('shopping')->remove($this->productId);
        $this->dispatch('cartCountUpdated');
        $this->dispatch('checkoutCartUpdated');
    }

    public function checkout()
    {
        $this->validate([
            'shipping_id' => 'required',
            'name'        => 'required',
            'phone'       => 'required',
        ]);

        if (Cart::instance('shopping')->count() === 0) {
            $this->alert('error', __('Your cart is empty'));
        }

        Shipping::find($this->shipping_id);

        $customer = Customer::where('email', $this->email)->first();

        if ($customer) {
            auth()->guard('customer')->login($customer);
        } else {
            $customer = Customer::create([
                'name'     => $this->name,
                'city'     => $this->city,
                'country'  => $this->country,
                'address'  => $this->address,
                'phone'    => $this->phone,
                'email'    => $this->email,
                'password' => bcrypt($this->password),
            ]);

            Mail::to($customer->email)->send(new CustomerRegistrationMail($customer));

            auth()->guard('customer')->login($customer);
        }

        $order = Order::create([
            'reference'      => Order::generateReference(),
            'date'           => now(),
            'shipping_id'    => $this->shipping_id,
            'user_id'        => null,
            'customer_id'    => $customer->id,
            'payment_method' => $this->payment_method,
            // 'shipping_amount' => $shipping->cost,
            'shipping_status' => ShippingStatus::PENDING,
            'total_amount'    => $this->cartTotal * 100,
            'payment_status'  => PaymentStatus::PENDING,
            'status'          => OrderStatus::PENDING,
            'delivery_id'     => null,
        ]);

        Mail::to($order->customer->email)->send(new CheckoutMail($order, $customer));

        foreach (Cart::instance('shopping')->content() as $item) {
            $product = Product::find($item->id);
            $orderDetails = new OrderDetails([
                'order_id'   => $order->id,
                'product_id' => $item->id,
                'code'       => $product->code,
                'name'       => $item->name,
                'quantity'   => $item->qty,
                'price'      => $item->price * 100,
                'unit_price' => $product->unit_price * 100,
                'sub_total'  => $item->qty * $product->unit_price * 100,
            ]);

            $orderDetails->save();
        }

        Cart::instance('shopping')->destroy();

        $this->alert('success', __('Order placed successfully!'));

        return redirect()->route('front.thankyou', $order->id);
    }

    public function mount(): void
    {
        // if customer is auth we could fill propreties like email phone and such
        if (auth()->guard('customer')->check()) {
            // dd(auth()->guard('customer')->user());
            $this->customer = auth()->guard('customer')->user();
            $this->name = $this->customer->name;
            $this->email = $this->customer->email;
            $this->phone = $this->customer->phone;
            $this->address = $this->customer->address;
            $this->city = $this->customer->city;
            $this->country = $this->customer->country;
        }
    }

    public function updateCartTotal(): void
    {
        if ($this->shipping_id) {
            $shipping = Shipping::find($this->shipping_id);
            $cost = $shipping->cost;
            $total = Cart::instance('shopping')->total();

            $this->cartTotal = $cost > 0 ? $total + $cost : $total;
        }
    }

    public function decreaseQuantity($rowId): void
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $qty = $cartItem->qty - 1;
        Cart::instance('shopping')->update($rowId, $qty);
        $this->dispatch('checkoutCartUpdated');
    }

    public function increaseQuantity($rowId): void
    {
        $cartItem = Cart::instance('shopping')->get($rowId);
        $qty = $cartItem->qty + 1;
        Cart::instance('shopping')->update($rowId, $qty);
        $this->dispatch('checkoutCartUpdated');
    }

    public function removeFromCart($rowId): void
    {
        $this->productId = $rowId;

        $this->confirm(
            __('Remove from cart ?'),
            [
                'position'          => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => 'confirm',
                'onConfirmed'       => 'confirmed',
                'showCancelButton'  => true,
                'cancelButtonText'  => 'cancel',
            ]
        );
    }

    #[Computed]
    public function shippings()
    {
        return Shipping::select('id', 'title')->get();
    }

    #[Computed]
    public function cartTotal()
    {
        return Cart::instance('shopping')->total();
    }

    #[Computed]
    public function cartItems()
    {
        return Cart::instance('shopping')->content();
    }

    #[Computed]
    public function subTotal()
    {
        return Cart::instance('shopping')->subtotal();
    }

    public function render(): View|Factory
    {
        return view('livewire.front.checkout');
    }
}
