<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $createModal = false;

    public Supplier $supplier;

    #[Rule('required|string|min:3|max:255', message: 'The name field is required and must be a string between 3 and 255 characters.')]
    public string $name;

    #[Rule('required|numeric', message: 'The phone field is required and must be a numeric value.')]
    public int $phone;

    #[Rule('nullable|email|max:255', message: 'The email field must be a valid email address with a maximum of 255 characters.')]
    public ?string $email = null;

    #[Rule('nullable|string|max:255', message: 'The address field must be a string with a maximum of 255 characters.')]
    public ?string $address = null;

    #[Rule('nullable|string|max:255', message: 'The city field must be a string with a maximum of 255 characters.')]
    public ?string $city = null;

    #[Rule('nullable|string|max:255', message: 'The country field must be a string with a maximum of 255 characters.')]
    public ?string $country = null;

    #[Rule('nullable|numeric|max:255', message: 'The tax number field must be a numeric value with a maximum of 255 characters.')]
    public ?int $tax_number = null;

    public function render()
    {
        abort_if(Gate::denies('supplier create'), 403);

        return view('livewire.admin.suppliers.create');
    }

    #[On('createModal')]
    public function createModal()
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        Supplier::create($this->all());

        $this->alert('success', __('Supplier created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset('name', 'email', 'phone', 'address', 'city', 'country', 'tax_number');

        $this->createModal = false;
    }
}
