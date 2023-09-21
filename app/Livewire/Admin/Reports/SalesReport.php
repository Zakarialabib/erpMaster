<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reports;

use App\Models\Customer;
use App\Models\Sale;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class SalesReport extends Component
{
    use WithPagination;

    public $customers;

    #[Rule('required', message: 'The start date field is required.')]
    #[Rule('date', message: 'The start date field must be a valid date.')]
    #[Rule('before:end_date', message: 'The start date field must be before the end date field.')]
    public $start_date;

    #[Rule('required', message: 'The end date field is required.')]
    #[Rule('date', message: 'The end date field must be a valid date.')]
    #[Rule('after:start_date', message: 'The end date field must be after the start date field.')]
    public $end_date;

    public $customer_id;

    public $sale_status;

    public $payment_status;


    public function mount(): void
    {
        $this->customers = Customer::select(['id', 'name'])->get();
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->customer_id = '';
        $this->sale_status = '';
        $this->payment_status = '';
    }

    public function render()
    {
        $sales = Sale::with('customer')->whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->when($this->customer_id, fn ($q) => $q->where('customer_id', $this->customer_id))
            ->when($this->sale_status, fn ($q) => $q->where('sale_status', $this->sale_status))
            ->when($this->payment_status, fn ($q) => $q->where('payment_status', $this->payment_status))
            ->orderBy('date', 'desc')->paginate(10);

        return view('livewire.admin.reports.sales-report', [
            'sales' => $sales,
        ]);
    }

    public function generateReport(): void
    {
        $this->validate();
        $this->render();
    }
}
