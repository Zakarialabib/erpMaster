<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Delivery;

use Livewire\Component;
use App\Models\Delivery;
use App\Models\Sale;
use App\Models\Shipping;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $editModal = false;

    /** @var mixed */
    public $delivery;

    #[Rule('required|string|max:255')]
    public $reference;


    #[Rule('nullable')]
    public $sale_id;

    #[Rule('nullable')]
    public $order_id;

    #[Rule('nullable')]
    public $shipping_id;

    #[Rule('nullable')]
    public $document;

    #[Rule('nullable')]
    public $note;

    #[Rule('nullable')]
    public $address;

    #[Rule('nullable')]
    public $delivered_by;

    #[Rule('nullable')]
    public $recieved_by;

    public function render()
    {
        return view('livewire.admin.delivery.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('delivery edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->delivery = Delivery::find($id);

        $this->reference = $this->delivery->reference;

        $this->sale_id = $this->delivery->sale_id;

        $this->order_id = $this->delivery->order_id;

        $this->shipping_id = $this->delivery->shipping_id;

        $this->document = $this->delivery->document;

        $this->note = $this->delivery->note;

        $this->address = $this->delivery->address;

        $this->delivered_by = $this->delivery->delivered_by;

        $this->recieved_by = $this->delivery->recieved_by;

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->delivery->update($this->all());

        $this->alert('success', __('Delivery updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }

    #[Computed]
    public function shippings()
    {
        return Shipping::all();
    }

    #[Computed]
    public function sales()
    {
        if ($this->order_id) {
            return  Sale::where('id', $this->sale_id)->get();
        }
        return Sale::all();
    }

    #[Computed]
    public function orders()
    {
        if ($this->order_id) {
            return  Order::where('id', $this->order_id)->get();
        }
        return Order::all();
    }
}
