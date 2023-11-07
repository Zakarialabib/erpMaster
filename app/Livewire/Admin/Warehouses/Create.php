<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Warehouses;

use App\Models\Warehouse;
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

    public Warehouse $warehouse;

    #[Rule('required')]
    #[Rule('max:255')]
    public $name;

    #[Rule('numeric')]
    public $phone;

    #[Rule('nullable')]
    #[Rule('max:255')]
    public $country;

    #[Rule('nullable')]
    #[Rule('max:255')]
    public $city;

    #[Rule('email')]
    #[Rule('max:255')]
    public $email;

    public function render()
    {
        abort_if(Gate::denies('warehouse create'), 403);

        return view('livewire.admin.warehouses.create');
    }

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

        Warehouse::create($this->all());

        $this->alert('success', __('Warehouse created successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset(['name', 'phone', 'country', 'city', 'email']);

        $this->createModal = false;
    }
}
