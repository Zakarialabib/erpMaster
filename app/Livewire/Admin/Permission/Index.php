<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Permission;

use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use App\Livewire\Utils\Datatable;
use Livewire\Attributes\On;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $permission;

    public $createModal = false;

    public $editModal = false;

    #[Validate('required|max:255|unique:permissions,name')]
    public $name;

    public $model = Permission::class;

    public function render()
    {
        $query = Permission::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $permissions = $query->paginate($this->perPage);

        return view('livewire.admin.permission.index', ['permissions' => $permissions]);
    }

    #[On('createModal')]
    public function createModal(): void
    {
        abort_if(Gate::denies('permission create'), 403);

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

    #[On('editModal')]
    public function editModal(Permission $permission): void
    {
        abort_if(Gate::denies('permission edit'), 403);

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

            $this->dispatch('refreshIndex')->to(Index::class);

            $this->editModal = false;
        } catch (Exception $exception) {
            $this->alert('error', 'Something goes wrong while updating permission!!'.$exception->getMessage());
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
