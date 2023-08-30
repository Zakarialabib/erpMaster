<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Role;

use App\Livewire\Utils\Datatable;
use App\Models\Role;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use Datatable;
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $role;

    public $permissions;

    /** @var array<string> */
    public $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function mount(): void
    {
        $this->orderable = (new Role())->orderable;
        // $this->permissions = $this->role->permissions->pluck('id')->toArray();
    }

    public function render()
    {
        $query = Role::with('permissions')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $roles = $query->paginate($this->perPage);

        return view('livewire.admin.role.index', compact('roles'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('role_delete'), 403);

        Role::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Role $role)
    {
        abort_if(Gate::denies('role_delete'), 403);

        $this->confirm(__('Are you sure ?'), [
            'toast'             => false,
            'position'          => 'center',
            'showConfirmButton' => true,
            'cancelButtonText'  => __('Cancel'),
            'onConfirmed'       => 'confirmedDelete',
        ]);
        $this->role = $role;
    }

    public function confirmedDelete()
    {
        abort_if(Gate::denies('role_delete'), 403);

        $this->role->delete();
        $this->dispatch('refreshIndex');
        $this->alert('success', __('Role removed'));
    }
}
