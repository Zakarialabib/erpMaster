<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Warehouses;

use App\Livewire\Utils\Datatable;
use App\Models\Warehouse;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use Datatable;
    use WithFileUploads;
    use LivewireAlert;

    /** @var mixed */
    public $warehouse;

    /** @var array<string> */
    public $listeners = [
        'refreshIndex' => '$refresh',
        'showModal', 'editModal',
        'delete',
    ];

    /** @var bool */
    public $showModal = false;

    /** @var bool */
    public $editModal = false;

    /** @var array */
    protected $rules = [
        'warehouse.name'    => 'string|required|max:255',
        'warehouse.phone'   => 'numeric|nullable',
        'warehouse.country' => 'nullable|max:255',
        'warehouse.city'    => 'nullable|max:255',
        'warehouse.email'   => 'nullable|max:255',
    ];

    public function mount(): void
    {
        $this->orderable = (new Warehouse())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('warehouse_access'), 403);

        $query = Warehouse::with('products')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $warehouses = $query->paginate($this->perPage);

        return view('livewire.admin.warehouses.index', compact('warehouses'));
    }

    public function showModal(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_show'), 403);

        $this->warehouse = Warehouse::find($warehouse->id);

        $this->showModal = true;
    }

    public function editModal(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->warehouse = Warehouse::find($warehouse->id);

        $this->editModal = true;
    }

    public function update(): void
    {
        abort_if(Gate::denies('warehouse_update'), 403);

        $this->validate();

        $this->warehouse->save();

        $this->editModal = false;

        $this->alert('success', __('Warehouse updated successfully'));
    }

    public function delete(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_delete'), 403);

        $warehouse->delete();

        $this->alert('warning', __('Warehouse successfully deleted.'));
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('warehouse_delete'), 403);

        Warehouse::whereIn('id', $this->selected)->delete();

        $this->alert('warning', __('Warehouses successfully deleted.'));
    }
}
