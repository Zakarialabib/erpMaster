<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\Warehouse;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;

    public $editModal = false;

    public $selectedWarehouses = [];

    public $user;

    #[Rule('required|string|max:255')]
    public $name;

    #[Rule('required|email')]
    public $email;

    #[Rule('required|string|min:8')]
    public $password;

    #[Rule('required|numeric')]
    public $phone;

    public $roles;

    #[Rule('nullable|string')]
    public $city;

    #[Rule('nullable|string')]
    public $country;

    #[Rule('nullable|string')]
    public $address;

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('user edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->user = User::findOrfail($id);

        $this->name = $this->user->name;

        $this->email = $this->user->email;

        $this->password = $this->user->password;

        $this->phone = $this->user->phone;

        $this->city = $this->user->city;

        $this->country = $this->user->country;

        $this->address = $this->user->address;

        $this->selectedWarehouses = $this->user->warehouses()->pluck('warehouses.id')->toArray() ?? [];
        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        $this->user->update([
            'name'     => $this->user->name,
            'email'    => $this->user->email,
            'password' => bcrypt($this->user->password),
            'phone'    => $this->user->phone,
            'city'     => $this->user->city,
            'country'  => $this->user->country,
            'address'  => $this->user->address,
        ]);

        $this->user->warehouses()->sync($this->selectedWarehouses);

        $this->alert('success', __('User Updated Successfully'));

        $this->editModal = false;
    }

    #[Computed]
    public function roles()
    {
        return Role::pluck('name', 'id')->toArray();
    }

    #[Computed]
    public function warehouses()
    {
        if (auth()->check()) {
            $user = auth()->user();

            return Warehouse::whereIn('id', $user->warehouses->pluck('id'))->select('name', 'id')->get();
        }

        return Warehouse::pluck('name', 'id')->toArray();
    }

    public function render(): View
    {
        return view('livewire.admin.users.edit');
    }
}
