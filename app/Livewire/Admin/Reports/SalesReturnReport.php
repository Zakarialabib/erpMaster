<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reports;

use App\Models\Customer;
use App\Models\SaleReturn;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReturnReport extends Component
{
    use WithPagination;

    public $customers;

    public $start_date;

    public $end_date;

    public $customer_id;

    public $sale_return_status;

    public $payment_status;

    protected $rules = [
        'start_date' => 'required|date|before:end_date',
        'end_date'   => 'required|date|after:start_date',
    ];

    public function mount()
    {
        $this->customers = Customer::select(['id', 'name'])->get();
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->customer_id = '';
        $this->sale_return_status = '';
        $this->payment_status = '';
    }

    public function render()
    {
        $sale_returns = SaleReturn::whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->when($this->customer_id, fn ($q) => $q->where('customer_id', $this->customer_id))
            ->when($this->sale_return_status, fn ($q) => $q->where('sale_return_status', $this->sale_return_status))
            ->when($this->payment_status, fn ($q) => $q->where('payment_status', $this->payment_status))
            ->orderBy('date', 'desc')->paginate(10);

        return view('livewire.admin.reports.sales-return-report', [
            'sale_returns' => $sale_returns,
        ]);
    }

    public function generateReport()
    {
        $this->validate();
        $this->render();
    }
}
