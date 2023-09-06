<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sales;

use App\Enums\PaymentStatus;
use App\Enums\SaleStatus;
use App\Models\Sale;
use App\Models\SalePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;
use Livewire\Attributes\Rule;

class PaymentForm extends Component
{
    use LivewireAlert;

    public $listeners = [
        'paymentModal',
    ];

    public $paymentModal;

    public $sale;

    public $sale_id;

    // public $reference;

    #[Rule('required|date')]
    public $date;

    #[Rule('required|numeric')]
    public $amount;

    #[Rule('required|string|max:100')]
    public $payment_method;

    #[Rule('nullable|numeric')]
    public $total_amount;
    #[Rule('nullable|numeric')]
    public $due_amount;
    #[Rule('nullable|numeric')]
    public $paid_amount;
    
    #[Rule('nullable|string|max:1000')]
    public $note;


    protected $rules = [
        'date'   => '',
        'amount' => '',
        'note'   => 'nullable|string|max:1000',
        // 'sale_id' => 'nullable|integer',
        'payment_method' => 'required|string|max:255',
    ];

    //  Payment modal

    public function paymentModal($id)
    {
        // abort_if(Gate::denies('sale access'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->sale = Sale::findOrFail($id);
        $this->date = date('Y-m-d');
        $this->amount = $this->sale->due_amount;
        $this->payment_method = 'Cash';
        $this->sale_id = $this->sale->id;
        $this->paymentModal = true;
    }

    public function paymentSave()
    {
        try {
            $this->validate();

            SalePayment::create([
                'date'           => $this->date,
                'amount'         => $this->amount,
                'note'           => $this->note,
                'sale_id'        => $this->sale_id,
                'payment_method' => $this->payment_method,
                'user_id'        => Auth::user()->id,
            ]);

            $sale = Sale::findOrFail($this->sale_id);

            $due_amount = $sale->due_amount - $this->amount;

            if ($due_amount === $sale->total_amount) {
                $payment_status = PaymentStatus::DUE;
                $status = SaleStatus::PENDING;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
                $status = SaleStatus::PENDING;
            } else {
                $payment_status = PaymentStatus::PAID;
                $status = SaleStatus::COMPLETED;
            }

            $sale->update([
                'paid_amount'    => ($sale->paid_amount + $this->amount) * 100,
                'due_amount'     => $due_amount * 100,
                'payment_status' => $payment_status,
                'status'         => $status,
            ]);

            $this->alert('success', __('Sale Payment created successfully.'));

            $this->paymentModal = false;

            $this->dispatch('refreshIndex')->to(Index::class);
        } catch (Throwable $th) {
            $this->alert('error', __('Error.').$th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.sales.payment-form');
    }
}
