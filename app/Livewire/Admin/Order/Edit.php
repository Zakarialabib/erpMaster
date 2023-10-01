<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Order;

use App\Models\Customer;
use Livewire\Component;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;

    /** @var bool */
    public $editModal = false;

    public $order;

    #[Rule('required', message : 'The date field is required.')]
    #[Rule('date', message : 'The date must be a valid date.')]
    public $date;

    public $reference;

    #[Rule('required', message : 'Sshipping field is required.')]
    public $shipping_id;

    #[Rule('required', message : 'Customer field is required.')]
    public $customer_id;

    public $tax_amount;

    public $discount_amount;

    public $total_amount;

    #[Rule('required', message : 'The payment date field is required.')]
    #[Rule('date', message : 'The payment date must be a valid date.')]
    public $payment_date;

    #[Rule('required', message : 'The payment method field is required.')]
    public $payment_method;

    #[Rule('required', message : 'The payment status field is required.')]
    public $payment_status;
    public $delivery_id;

    #[Rule('required', message : 'The status field is required.')]
    public $status;
    public $document;
    public $note;

    public function render()
    {
        return view('livewire.admin.order.edit');
    }

    #[On('editModal')]
    public function editModal($id): void
    {
        abort_if(Gate::denies('expense edit'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->order = Order::find($id);

        $this->date = $this->order->date;

        $this->reference = $this->order->reference;

        $this->shipping_id = $this->order->shipping_id;

        $this->customer_id = $this->order->customer_id;

        $this->tax_amount = $this->order->tax_amount;

        $this->discount_amount = $this->order->discount_amount;

        $this->total_amount = $this->order->total_amount;

        $this->payment_date = $this->order->payment_date;

        $this->payment_method = $this->order->payment_method;

        $this->payment_status = $this->order->payment_status;

        $this->delivery_id = $this->order->delivery_id;

        $this->status = $this->order->status;

        $this->document = $this->order->document;

        $this->note = $this->order->note;

        $this->editModal = true;
    }

    #[Computed]
    public function shippings()
    {
        return Shipping::select('id', 'title')->get();
    }

    #[Computed]
    public function customers()
    {
        return Customer::select('id', 'name')->get();
    }


    public function update(): void
    {
        $this->validate();

        $this->order->update([
            'date' => $this->date,
            'reference' => $this->reference,
            'shipping_id' => $this->shipping_id,
            'customer_id' => $this->customer_id,
            'tax_amount' => $this->tax_amount,
            'discount_amount' => $this->discount_amount,
            'total_amount' => $this->total_amount,
            'payment_date' => $this->payment_date,
            'payment_method' => $this->payment_method,
            'payment_status' => $this->payment_status,
            'status' => $this->status,
            'document' => $this->document,
            'note' => $this->note,
        ]);

        $this->alert('success', __('Order updated successfully.'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->editModal = false;
    }
}
