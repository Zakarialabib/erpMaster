<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Role;

use App\Livewire\Utils\Datatable;
use App\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class Index extends Component
{
    use Datatable;

    public function mount()
    {
        $this->orderable = (new Role())->orderable;
    }

    public function render()
    {
        $query = Role::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $roles = $query->paginate($this->perPage);

        return view('livewire.admin.role.index', ['roles' => $roles]);
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Role::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Role $role)
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $role->delete();
    }
}
