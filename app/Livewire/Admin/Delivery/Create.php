<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Delivery;

use App\Enums\ShippingStatus;
use App\Livewire\Utils\Admin\WithModels;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Shipping;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Computed;

class Create extends Component
{
    use LivewireAlert;
    use WithModels;

    public $createModal = false;
    public Delivery $delivery;

    #[Rule('required')]
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
    public $status;

    public function render()
    {
        abort_if(Gate::denies('delivery create'), 403);

        return view('livewire.admin.delivery.create');
    }

    #[On('createModal')]
    public function createModal($item_id = null, $type = null): void
    {
        if ($type == 'order') {
            $this->order_id = $item_id;
            $order = Order::where('id', $this->order_id)->first();
            $this->address = $order->customer->address;
            $this->shipping_id = $order->shipping_id;

            // dd($order);
        } elseif ($type == 'sale') {
            $this->sale_id = $item_id;
            $sale = Sale::where('id', $this->sale_id)->first();
            $this->address = $sale->customer->address;
            $this->shipping_id = $sale->shipping_id;
        }

        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->status = ShippingStatus::PENDING;

        $this->delivery = Delivery::create($this->all());

        $this->delivery->user()->associate(auth()->user());

        $this->alert('success', __('Delivery created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }

    #[Computed]
    public function shippings()
    {
        return Shipping::all();
    }

    // Sale with status pending or processing 
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
