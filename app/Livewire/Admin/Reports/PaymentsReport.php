<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Reports;

use App\Models\PurchasePayment;
use App\Models\PurchaseReturnPayment;
use App\Models\SalePayment;
use App\Models\SaleReturnPayment;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Gate;

#[Layout('components.layouts.dashboard')]
class PaymentsReport extends Component
{
    use WithPagination;

    #[Rule('required', message: 'The start date field is required.')]
    #[Rule('date', message: 'The start date field must be a valid date.')]
    #[Rule('before:end_date', message: 'The start date field must be before the end date field.')]
    public $start_date;

    #[Rule('required', message: 'The end date field is required.')]
    #[Rule('date', message: 'The end date field must be a valid date.')]
    #[Rule('after:start_date', message: 'The end date field must be after the start date field.')]
    public $end_date;

    public $payments;

    public $payment_method;

    protected $rules = [
        'payments' => 'required|string',
    ];

    protected $query;

    public function mount(): void
    {
        $this->start_date = today()->subDays(30)->format('Y-m-d');
        $this->end_date = today()->format('Y-m-d');
        $this->payments = '';
        $this->query = null;
    }

    public function render()
    {
        abort_if(Gate::denies('report access'), 403);

        $this->getQuery();

        return view('livewire.admin.reports.payments-report', [
            'information' => $this->query ? $this->query->orderBy('date', 'desc')
                ->when($this->payment_method, fn ($query) => $query->where('payment_method', $this->payment_method))
                ->paginate(10) : collect(),
        ]);
    }

    public function generateReport(): void
    {
        $this->validate();
        $this->render();
    }

    public function updatedPayments($value): void
    {
        $this->resetPage();
    }

    public function getQuery(): void
    {
        if ($this->payments === 'sale') {
            $this->query = SalePayment::query()->with('sale');
        } elseif ($this->payments === 'sale_return') {
            $this->query = SaleReturnPayment::query()->with('saleReturn');
        } elseif ($this->payments === 'purchase') {
            $this->query = PurchasePayment::query()->with('purchase');
        } elseif ($this->payments === 'purchase_return') {
            $this->query = PurchaseReturnPayment::query()->with('purchaseReturn');
        } else {
            $this->query = null;
        }
    }
}
