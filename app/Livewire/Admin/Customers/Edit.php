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
use Throwable;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    /** @var mixed */
    public $customer;

    #[Rule('required|string|min:3|max:255', message: 'The name field is required and must be a string between 3 and 255 characters.')]
    public string $name;

    #[Rule('nullable|email|max:255', message: 'The email field must be a valid email address with a maximum of 255 characters.')]
    public ?string $email = null;

    #[Rule('required|numeric', message: 'The phone field is required and must be a numeric value.')]
    public string $phone;

    #[Rule('nullable|max:255', message: 'The city field must be a string with a maximum of 255 characters.')]
    public ?string $city = null;

    #[Rule('nullable|max:255', message: 'The country field must be a string with a maximum of 255 characters.')]
    public ?string $country = null;

    #[Rule('nullable|max:255', message: 'The address field must be a string with a maximum of 255 characters.')]
    public ?string $address = null;

    #[Rule('nullable|max:255', message: 'The tax number field must be a string with a maximum of 255 characters.')]
    public ?string $tax_number = null;

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
