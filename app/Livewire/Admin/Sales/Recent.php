<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Livewire\Utils\Datatable;
use App\Models\Sale;

use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Recent extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use Datatable;

    public $sale;

    /** @var array<string> */
    public $listeners = [
        'recentSales', 'showModal',
    ];

    public $showModal = false;

    public $recentSales;

    public function mount(): void
    {
        $this->orderable = (new Sale())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('sale access'), 403);

        $query = Sale::with('customer', 'saleDetails')->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $sales = $query->paginate($this->perPage);

        return view('livewire.admin.sales.recent', ['sales' => $sales]);
    }

    public function showModal($id)
    {
        abort_if(Gate::denies('sale access'), 403);

        $this->sale = Sale::with('saleDetails')->whereId($id)->first();

        $this->showModal = true;
    }

    public function recentSales()
    {
        abort_if(Gate::denies('sale access'), 403);

        $this->recentSales = true;
    }
}
