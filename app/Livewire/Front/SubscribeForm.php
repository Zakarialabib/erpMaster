<?php

declare(strict_types=1);

namespace App\Livewire\Front;

use App\Enums\OrderType;
use App\Enums\Status;
use App\Models\OrderForms;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Mail\OrderFormMail;
use Illuminate\Support\Facades\Mail;

class SubscribeForm extends Component
{
    use LivewireAlert;

    public $name;

    public $phone;

    public $email;

    public $type;

    public $status;

    public $race;

    public function mount($race): void
    {
        $this->race = $race;
    }

    public function render(): View|Factory
    {
        return view('livewire.front.subscribe-form');
    }

    public function save(): void
    {
        $this->validate([
            'name'  => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $order = OrderForms::create([
            'name'    => $this->name,
            'phone'   => $this->phone,
            'email'   => $this->email,
            'type'    => OrderType::PRODUCT,
            'status'  => Status::ACTIVE,
            'subject' => __('New request for ').$this->race->name,
            'message' => $this->name.__(' has sent a request for ').$this->race->name,
        ]);

        $this->alert('success', __('Your order has been sent successfully!'));

        Mail::to(settings('company_email'))->send(new OrderFormMail($order));

        $this->reset();
    }
}
