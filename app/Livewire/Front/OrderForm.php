<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Models\OrderForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Mail\OrderFormMail;
use Illuminate\Support\Facades\Mail;

class OrderForm extends Component
{
    use LivewireAlert;

    #[Rule('required', message : 'This field is required')]
    public $name;

    #[Rule('required', message : 'This field is required')]
    #[Rule('numeric', message : 'This field must be number')]
    public $phone;

    #[Rule('required', message : 'This field is required')]
    public $address;

    public $type;

    public $status;

    public $subject;

    public $message;

    public $product;

    public function mount($product): void
    {
        $this->product = $product;
    }

    public function render(): View|Factory
    {
        return view('livewire.front.order-form');
    }

    public function save(): void
    {
        $this->validate();

        $order = OrderForms::create([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'address' => $this->address,
            'type'    => OrderForms::PRODUCT_FORM,
            'status'  => OrderForms::STATUS_PENDING,
            'subject' => __('New request for ').$this->product->name,
            'message' => $this->name.__(' has sent a request for ').$this->product->name,
        ]);

        $this->alert('success', __('Your order has been sent successfully!'));

        Mail::to(settings('company_email'))->send(new OrderFormMail($order));

        $this->reset();
    }
}
