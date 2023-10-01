<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Order;
use App\Models\Customer;

class CheckoutMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var \App\Models\Order */
    public $order;

    /** @var \App\Models\Customer */
    public $customer;

    public function __construct(Order $order, Customer $customer)
    {
        $this->order = $order;
        $this->customer = $customer;
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.checkout',
            with: [
                'order'    => $this->order,
                'customer' => $this->customer,
            ]
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Hello ').$this->customer->name.__(', your order has been placed'),
        );
    }
}
