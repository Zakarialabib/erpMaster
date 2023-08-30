<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Users;

use App\Livewire\Utils\Datatable;
use App\Models\User;

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
    public $user;

    /** @var array<string> */
    public $listeners = [
        'refreshIndex' => '$refresh',
        'delete',
    ];

    public function mount(): void
    {
        $this->orderable = (new User())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('user_access'), 403);

        $query = User::with(['roles'])->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $users = $query->paginate($this->perPage);

        return view('livewire.admin.users.index', compact('users'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('user_delete'), 403);

        User::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(User $user)
    {
        abort_if(Gate::denies('user_delete'), 403);

        $user->delete();

        $this->alert('warning', __('User deleted successfully!'));
    }
}
