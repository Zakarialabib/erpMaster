<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Shipping;

use App\Models\Shipping;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createShipping;

    public $listeners = ['createShipping'];

    public $shipping;

    public array $rules = [
        'shipping.is_pickup' => ['integer'],
        'shipping.title'     => ['required', 'string', 'max:255'],
        'shipping.subtitle'  => ['nullable', 'string', 'max:255'],
        'shipping.cost'      => ['required', 'string'],
    ];

    public function render()
    {
        // abort_if(Gate::denies('shipping_create'), 403);

        return view('livewire.admin.shipping.create');
    }

    public function createShipping()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->shipping = new Shipping();

        $this->shipping->is_pickup = false;

        $this->createShipping = true;
    }

    public function create()
    {
        $this->validate();

        $this->shipping->save();

        $this->alert('success', __('Shipping created successfully.'));

        $this->emit('refreshIndex');

        $this->createShipping = false;
    }
}
