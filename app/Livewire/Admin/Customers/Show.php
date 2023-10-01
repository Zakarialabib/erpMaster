<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\On;

class Show extends Component
{
    public $showModal = false;

    public $customer;

    #[On('showModal')]
    public function showModal($id): void
    {
        abort_if(Gate::denies('customer access'), 403);

        $this->customer = Customer::find($id);

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.admin.customers.show');
    }
}
