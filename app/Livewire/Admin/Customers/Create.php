<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use Livewire\Component;
use App\Models\Role;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Customer $customer;

    #[Validate('required', message: 'The name field is required')]
    #[Validate('min:3', message: 'The name field must be more than 3 characters.')]
    #[Validate('max:255', message: 'The name field must be less 255 characters.')]
    public string $name;

    public $email;

    #[Validate('required', message: 'The phone field is required')]
    #[Validate('numeric', message: 'The phone field must be a numeric value.')]
    public $phone;

    public $city;

    public $country;

    public $address;

    public $tax_number;

    public $customer_group_id;

    public $role;

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

    #[Computed]
    public function customerGroups()
    {
        return CustomerGroup::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function roles()
    {
        return Role::pluck('name', 'id')->toArray();
    }

    public function render()
    {
        abort_if(Gate::denies('customer create'), 403);

        return view('livewire.admin.customers.create');
    }
}
