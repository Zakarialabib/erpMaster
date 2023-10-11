<?php

declare(strict_types=1);

namespace App\Livewire\Admin\PurchaseReturn;

use App\Models\PurchaseReturn;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Attributes\Rule;

class Create extends Component
{
    use LivewireAlert;

    public $warehouse_id;

    #[Rule('required')]
    public $supplier_id;

    #[Rule('required|string|max:255')]
    public $reference;

    #[Rule('required|integer|min:0|max:100')]
    public $tax_percentage;

    #[Rule('required|integer|min:0|max:100')]
    public $discount_percentage;

    #[Rule('required|numeric')]
    public $shipping_amount;

    #[Rule('required|numeric')]
    public $total_amount;

    #[Rule('required|numeric')]
    public $paid_amount;

    #[Rule('required|integer|max:255')]
    public $status;

    #[Rule('required|integer|max:255')]
    public $payment_method;

    #[Rule('nullable|string|max:1000')]
    public $note;

    public function mount(): void
    {
        abort_if(Gate::denies('purchase return create'), 403);

        if (settings('default_warehouse_id') !== null) {
            $this->warehouse_id = settings('default_warehouse_id');
        }

        Cart::instance('purchase_return')->destroy();
    }

    public function create(): void
    {
        abort_if(Gate::denies('purchase create'), 403);

        $this->validate();

        PurchaseReturn::create($this->all());

        $this->alert('success', 'PurchaseReturn created successfully.');
    }

    public function render()
    {
        return view('livewire.admin.purchase-return.create');
    }
}
