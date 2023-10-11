<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Customer $customer;

    #[Rule('required', message: 'The name field is required')]
    #[Rule('min:3', message: 'The name field must be more than 3 characters.')]
    #[Rule('max:255', message: 'The name field must be less 255 characters.')]
    public string $name;

    public $email;

    #[Rule('required', message: 'The phone field is required')]
    #[Rule('numeric', message: 'The phone field must be a numeric value.')]
    public $phone;

    public $city;

    public $country;

    public $address;

    public $tax_number;

    #[On('createModal')]
    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        Customer::create($this->all());

        $this->alert('success', __('Customer created successfully'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->createModal = false;
    }

    public function render()
    {
        abort_if(Gate::denies('customer create'), 403);

        return view('livewire.admin.customers.create');
    }
}
