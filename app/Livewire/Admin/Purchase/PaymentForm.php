<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Purchase;

use Livewire\Component;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Throwable;

class PaymentForm extends Component
{
    use LivewireAlert;

    public $paymentModal = false;

    public $purchase;

    public $purchase_id;

    public $date;

    // public $reference;
    public $amount;

    public $payment_method;

    public $due_amount;

    public $total_amount;
    
    public $paid_amount;

    public $note;

    public $listeners = [
        'paymentModal',
    ];

    protected $rules = [
        'date'   => 'required|date',
        'amount' => 'required|numeric',
        'note'   => 'nullable|string|max:1000',
        // 'sale_id' => 'nullable|integer',
        'payment_method' => 'required|string|max:255',
    ];

    public function render()
    {
        return view('livewire.admin.purchase.payment-form');
    }

    //  Payment modal

    public function paymentModal($id): void
    {
        // abort_if(Gate::denies('purchase payment'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->purchase = Purchase::findOrFail($id);
        $this->date = date('Y-m-d');
        $this->amount = $this->purchase->due_amount;
        $this->payment_method = 'Cash';
        $this->purchase_id = $this->purchase->id;
        $this->paymentModal = true;
    }

    public function paymentSave(): void
    {
        try {
            $this->validate();

            PurchasePayment::create([
                'date'           => $this->date,
                'user_id'        => Auth::user()->id,
                'amount'         => $this->amount,
                'note'           => $this->note ?? null,
                'purchase_id'    => $this->purchase_id,
                'payment_method' => $this->payment_method,
            ]);

            $purchase = Purchase::findOrFail($this->purchase_id);

            $due_amount = $purchase->due_amount - $this->amount;

            if ($due_amount === $purchase->total_amount) {
                $payment_status = PaymentStatus::DUE;
                $status = PurchaseStatus::PENDING;
            } elseif ($due_amount > 0) {
                $payment_status = PaymentStatus::PARTIAL;
                $status = PurchaseStatus::PENDING;
            } else {
                $payment_status = PaymentStatus::PAID;
                $status = PurchaseStatus::COMPLETED;
            }

            $purchase->update([
                'paid_amount'    => ($purchase->paid_amount + $this->amount) * 100,
                'due_amount'     => $due_amount * 100,
                'payment_status' => $payment_status,
                'status'         => $status,
            ]);

            $this->alert('success', __('Purchase Payment created successfully.'));

            $this->paymentModal = false;

            $this->dispatch('refreshIndex')->to(Index::class);
        } catch (Throwable $throwable) {
            $this->alert('error', 'Error'.$throwable->getMessage());
        }
    }
}
