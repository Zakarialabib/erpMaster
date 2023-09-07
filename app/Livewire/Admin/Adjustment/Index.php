<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Adjustment;

use App\Livewire\Utils\Datatable;
use App\Models\Adjustment;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Index extends Component
{
    use Datatable;
    use WithFileUploads;
    use LivewireAlert;

    /** @var mixed */
    public $adjustment;

    /** @var array<string> */
    public $listeners = [
        'delete',
    ];

    public function mount(): void
    {
        $this->orderable = (new Adjustment())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('adjustment access'), 403);

        $query = Adjustment::with('adjustedProducts', 'adjustedProducts.warehouse', 'adjustedProducts.product')
            ->advancedFilter([
                's'               => $this->search ?: null,
                'order_column'    => $this->sortBy,
                'order_direction' => $this->sortDirection,
            ]);

        $adjustments = $query->paginate($this->perPage);

        return view('livewire.admin.adjustment.index', ['adjustments' => $adjustments]);
    }

    public function deleteSelected(): void
    {
        // abort_if(Gate::denies('adjustment_delete'), 403);

        Adjustment::whereIn('id', $this->selected)->delete();

        $this->resetSelected();

        $this->alert('success', __('Adjustment deleted successfully.'));
    }

    public function delete(Adjustment $adjustment): void
    {
        abort_if(Gate::denies('adjustment_delete'), 403);

        $adjustment->delete();

        $this->alert('success', __('Adjustment deleted successfully.'));
    }
}
