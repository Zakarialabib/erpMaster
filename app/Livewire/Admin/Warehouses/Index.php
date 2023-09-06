<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Warehouses;

use App\Livewire\Utils\Datatable;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use WithFileUploads;
    use LivewireAlert;

    /** @var mixed */
    public $warehouse;

    /** @var array<string> */
    public $listeners = [
        'delete',
    ];

    /** @var bool */
    public $showModal = false;

    public function mount(): void
    {
        $this->orderable = (new Warehouse())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('warehouse access'), 403);

        $query = Warehouse::with('products')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $warehouses = $query->paginate($this->perPage);

        return view('livewire.admin.warehouses.index', compact('warehouses'));
    }

    #[On('showModal')]
    public function showModal(Warehouse $warehouse)
    {
        abort_if(Gate::denies('warehouse_show'), 403);

        $this->warehouse = Warehouse::find($warehouse->id);

        $this->showModal = true;
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
