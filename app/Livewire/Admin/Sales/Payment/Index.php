<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales\Payment;

use App\Livewire\Utils\Datatable;
use App\Models\SalePayment;
use App\Models\Sale;

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

    public $sale;

    /** @var array<string> */
    public $listeners = [
        'showPayments',
        'refreshIndex' => '$refresh',
    ];

    public $showPayments;

    public $listsForFields = [];

    public $sale_id;

    public function mount($sale)
    {
        $this->sale = $sale;

        $this->perPage = 10;
        $this->sortBy = 'id';
        $this->sortDirection = 'desc';
        $this->paginationOptions = config('project.pagination.options');
        $this->orderable = (new SalePayment())->orderable;
    }

    public function render()
    {
        abort_if(Gate::denies('sale_payment_access'), 403);

        $query = SalePayment::where('sale_id', $this->sale_id)->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $salepayments = $query->paginate($this->perPage);

        return view('livewire.admin.sales.payment.index', compact('salepayments'));
    }

    public function showPayments($sale_id)
    {
        abort_if(Gate::denies('sale_access'), 403);

        $this->sale = Sale::findOrFail($sale_id);

        $this->showPayments = true;
    }
}
