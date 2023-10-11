<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    /** @var mixed */
    public $customer;

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

    public function render()
    {
        return view('livewire.admin.customers.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('customer_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->customer = Customer::findOrFail($id);

        $this->name = $this->customer->name;

        $this->email = $this->customer->email;

        $this->phone = $this->customer->phone;

        $this->city = $this->customer->city;

        $this->country = $this->customer->country;

        $this->address = $this->customer->address;

        $this->tax_number = $this->customer->tax_number;

        $this->editModal = true;
    }

    public function update(): void
    {
        $validatedData = $this->validate();

        $this->customer->update($validatedData);

        $this->alert('success', __('Customer updated successfully.'));

        $this->editModal = false;

        $this->dispatch('refreshIndex')->to(Index::class);
    }
}
