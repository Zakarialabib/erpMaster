<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Quotations;

use App\Livewire\Utils\Admin\WithModels;
use App\Livewire\Utils\Datatable;
use App\Models\Quotation;
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
    use WithModels;

    public $quotation;

    /** @var array<string> */
    public $listeners = [
        'delete',
    ];

    public function mount(): void
    {
        $this->orderable = (new Quotation())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('quotation access'), 403);

        $query = Quotation::advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $quotations = $query->paginate($this->perPage);

        return view('livewire.admin.quotations.index', ['quotations' => $quotations]);
    }

    public function deleteSelected()
    {
        abort_if(Gate::denies('quotation_delete'), 403);

        Quotation::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Quotation $product)
    {
        abort_if(Gate::denies('quotation_delete'), 403);

        $product->delete();

        $this->alert('success', __('Quotation deleted successfully.'));
    }
}
