<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Livewire\Utils\Datatable;
use App\Models\Sale;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Recent extends Component
{
    use WithPagination;
    use Datatable;
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;

    public $sale;

    /** @var array<string> */
    public $listeners = [
        'recentSales', 'showModal',
        'refreshIndex' => '$refresh',
    ];

    public $showModal = false;

    public $recentSales;

    public $listsForFields = [];

    public function mount(): void
    {
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->perPage = 10;
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new Sale())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('sale_access'), 403);

        $query = Sale::with('customer', 'saleDetails')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sales = $query->paginate($this->perPage);

        return view('livewire.admin.sales.recent', compact('sales'));
    }

    public function showModal($id)
    {
        abort_if(Gate::denies('sale_access'), 403);

        $this->sale = Sale::with('saleDetails')->findOrFail($id);

        $this->showModal = true;
    }

    public function recentSales()
    {
        abort_if(Gate::denies('sale_access'), 403);

        $this->recentSales = true;
    }
}
