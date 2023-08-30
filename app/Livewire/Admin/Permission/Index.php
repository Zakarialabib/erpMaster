<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Permission;

use App\Livewire\Utils\Datatable;
use App\Models\Permission;

use Exception;
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
    public $permission;

    /** @var array<string> */
    public $listeners = [
        'createModal', 'editModal',
        'refreshIndex' => '$refresh',
    ];

    public $createModal = false;

    public $editModal = false;

    protected $rules = [
        'name' => 'required|max:255|unique:permissions,name',
    ];

    public function mount(): void
    {
        $this->orderable = (new Permission())->orderable;
    }

    public function render()
    {
        $query = Permission::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $permissions = $query->paginate($this->perPage);

        return view('livewire.admin.permission.index', compact('permissions'));
    }

    public function createModal(): void
    {
        abort_if(Gate::denies('permission_create'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->createModal = true;
    }

    public function create(): void
    {
        $this->validate();

        Permission::create($this->permission);

        $this->createModal = false;

        $this->alert('success', __('Permission created successfully.'));
    }

    public function editModal(Permission $permission): void
    {
        abort_if(Gate::denies('permission_edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->permission = Permission::find($permission->id);

        $this->editModal = true;
    }

    public function update(): void
    {
        $this->validate();

        try {
            // Update category
            $this->permission->update([
                'name' => $this->name,
            ]);

            $this->alert('success', __('Permission updated successfully.'));

            $this->dispatch('refreshIndex');

            $this->editModal = false;
        } catch (Exception $e) {
            $this->alert('error', 'Something goes wrong while updating permission!!'.$e->getMessage());
        }
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('permission_delete'), 403);

        Permission::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Permission $permission): void
    {
        abort_if(Gate::denies('permission_delete'), 403);

        $permission->delete();

        $this->alert('success', __('Permission deleted successfully.'));
    }
}
