<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reports;

use App\Models\Purchase;
use App\Models\Supplier;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class PurchasesReport extends Component
{
    use WithPagination;

    public $suppliers;

    #[Rule('required', message: 'The start date field is required.')]
    #[Rule('date', message: 'The start date field must be a valid date.')]
    #[Rule('before:end_date', message: 'The start date field must be before the end date field.')]
    public $start_date;

    #[Rule('required', message: 'The end date field is required.')]
    #[Rule('date', message: 'The end date field must be a valid date.')]
    #[Rule('after:start_date', message: 'The end date field must be after the start date field.')]
    public $end_date;
    public $supplier_id;

    public $purchase_status;

    public $payment_status;


    public function mount(): void
    {
        $this->suppliers = Supplier::select(['id', 'name'])->get();
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->supplier_id = '';
        $this->purchase_status = '';
        $this->payment_status = '';
    }

    public function render()
    {
        $purchases = Purchase::whereDate('date', '>=', $this->start_date)
            ->whereDate('date', '<=', $this->end_date)
            ->when($this->supplier_id, fn ($query) => $query->where('supplier_id', $this->supplier_id))
            ->when($this->purchase_status, fn ($query) => $query->where('status', $this->purchase_status))
            ->when($this->payment_status, fn ($query) => $query->where('payment_status', $this->payment_status))
            ->orderBy('date', 'desc')->paginate(10);

        return view('livewire.admin.reports.purchases-report', [
            'purchases' => $purchases,
        ]);
    }

    public function generateReport(): void
    {
        $this->validate();
        $this->render();
    }
}
