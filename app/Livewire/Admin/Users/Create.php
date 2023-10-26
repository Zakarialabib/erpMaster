<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\User;
use App\Models\Role;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{
    use LivewireAlert;

    public $createModal;

    public User $user;

    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|email|unique:users,email')]
    public $email;

    #[Rule('required|string|min:8')]
    public $password;

    #[Rule('required|numeric')]
    public $phone;


    public $city;


    public $country;


    public $address;

    public $selectedWarehouses = [];

    public $warehouse_id;

    public function render()
    {
        return view('livewire.admin.users.create');
    }

    public function createModal(): void
    {
        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        $this->user = User::create($this->all());

        $this->user->warehouses()->sync($this->selectedWarehouses);

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->alert('success', 'User created successfully!');

        $this->createModal = false;
    }

    #[Computed]
    public function warehouses()
    {
        return Warehouse::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function roles()
    {
        return Role::pluck('name', 'id')->toArray();
    }
}
