<?php

declare(strict_types=1);

namespace App\Livewire\Admin\PurchaseReturn;

use App\Models\PurchaseReturn;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Gloudemans\Shoppingcart\Facades\Cart;

class Create extends Component
{
    use LivewireAlert;
    public bool $createModal = false;

    protected $rules = [
        'supplier_id'         => 'required|numeric',
        'reference'           => 'required|string|max:255',
        'tax_percentage'      => 'required|integer|min:0|max:100',
        'discount_percentage' => 'required|integer|min:0|max:100',
        'shipping_amount'     => 'required|numeric',
        'total_amount'        => 'required|numeric',
        'paid_amount'         => 'required|numeric',
        'status'              => 'required|integer|max:255',
        'payment_method'      => 'required|integer|max:255',
        'note'                => 'nullable|string|max:1000',
    ];

    #[On('createModal')]
    public function mount(): void
    {
        abort_if(Gate::denies('purchase return create'), 403);

        Cart::instance('purchase_return')->destroy();
    }

    public function create(): void
    {
        abort_if(Gate::denies('purchase create'), 403);

        $this->validate();

        PurchaseReturn::create($this->all());

        $this->createModal = false;

        $this->alert('success', 'PurchaseReturn created successfully.');
    }

    public function render()
    {
        return view('livewire.admin.purchase-return.create');
    }
}
