<?php

declare(strict_types=1);

namespace App\Livewire\Admin\CustomerGroup;

use App\Livewire\Utils\Datatable;
use App\Models\CustomerGroup;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use LivewireAlert;
    use Datatable;

    /** @var mixed */
    public $customergroup;

    public $showModal = false;

    public $model = CustomerGroup::class;

    /** @var array<string> */
    public $listeners = [
        'showModal',
        'delete',
    ];

    public function render()
    {
        abort_if(Gate::denies('customer group access'), 403);

        $query = CustomerGroup::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $customergroups = $query->paginate($this->perPage);

        return view('livewire.admin.customer-group.index', ['customergroups' => $customergroups]);
    }

    public function showModal($id): void
    {
        abort_if(Gate::denies('customer group show'), 403);

        $this->customergroup = CustomerGroup::where('id', $id)->get();

        $this->showModal = true;
    }

    public function deleteSelected(): void
    {
        abort_if(Gate::denies('customer group delete'), 403);

        CustomerGroup::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(CustomerGroup $customergroup): void
    {
        abort_if(Gate::denies('customer group delete'), 403);

        $customergroup->delete();

        $this->alert('success', __('Expense Category Deleted Successfully.'));
    }
}
