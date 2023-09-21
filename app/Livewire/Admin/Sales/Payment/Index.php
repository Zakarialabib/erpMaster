<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales\Payment;

use App\Livewire\Utils\Datatable;
use App\Models\SalePayment;
use App\Models\Sale;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;
    use Datatable;

    public $sale;

    public $model = SalePayment::class;

    public $listeners = [
        'showPayments',
    ];

    public $showPayments;

    public $sale_id;

    public function mount($sale): void
    {
        $this->sale = $sale;
    }

    public function render()
    {
        abort_if(Gate::denies('sale payment access'), 403);

        $query = SalePayment::where('sale_id', $this->sale->id)->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $salepayments = $query->paginate($this->perPage);

        return view('livewire.admin.sales.payment.index', ['salepayments' => $salepayments]);
    }

    public function showPayments($sale_id): void
    {
        abort_if(Gate::denies('sale access'), 403);

        $this->sale = Sale::findOrFail($sale_id);

        $this->showPayments = true;
    }
}
