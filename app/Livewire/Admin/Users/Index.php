<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Livewire\Utils\Datatable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use LivewireAlert;

    public $showModal = false;

    public $model = User::class;

    public $user;

    public $role;

    public $filterRole;

    public array $rules = [
        'user.name'       => 'required|string|max:255',
        'user.email'      => 'required|email|unique:users,email',
        'user.password'   => 'required|string|min:8',
        'user.phone'      => 'required|numeric',
        'user.city'       => 'nullable',
        'user.country'    => 'nullable',
        'user.address'    => 'nullable',
        'user.tax_number' => 'nullable',
    ];

    public function filterRole($role): void
    {
        $this->filterRole = $role;
        $this->resetPage(); // Reset pagination to the first page
    }

    public function render()
    {
        abort_if(Gate::denies('user access'), 403);

        $query = User::with('roles')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.users.index', ['users' => $users]);
    }

    // getrolesproperty
    public function getRolesProperty()
    {
        return Role::pluck('name', 'id');
    }

    // assign or change user role
    public function assignRole(User $user, $role): void
    {
        $user->assignRole($role);
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('user_delete'), 403);

        User::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(User $user): void
    {
        abort_if(Gate::denies('user_delete'), 403);

        $user->delete();

        $this->alert('warning', __('User deleted successfully!'));
    }

    public function showModal(User $user): void
    {
        $this->user = $user;

        $this->showModal = true;
    }
}
