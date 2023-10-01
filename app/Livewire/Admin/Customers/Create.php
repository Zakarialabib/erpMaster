<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class Create extends Component
{
    use LivewireAlert;

    public $createModal = false;

    public Customer $customer;

    #[Rule('required|string|min:3|max:255', message: 'The name field is required and must be a string between 3 and 255 characters.')]
    public string $name;

    #[Rule('nullable|email|max:255', message: 'The email field must be a valid email address with a maximum of 255 characters.')]
    public ?string $email = null;

    #[Rule('required|numeric', message: 'The phone field is required and must be a numeric value.')]
    public string $phone;

    #[Rule('nullable|min:3|max:255', message: 'The city field must be a string between 3 and 255 characters.')]
    public ?string $city = null;

    #[Rule('nullable|min:3|max:255', message: 'The country field must be a string between 3 and 255 characters.')]
    public ?string $country = null;

    #[Rule('nullable|max:255', message: 'The address field must be a string with a maximum of 255 characters.')]
    public ?string $address = null;

    #[Rule('nullable|max:255', message: 'The tax number field must be a string with a maximum of 255 characters.')]
    public ?string $tax_number = null;

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
