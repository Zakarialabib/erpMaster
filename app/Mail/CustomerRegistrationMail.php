<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use App\Models\Customer;

class CustomerRegistrationMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var \App\Models\Customer */
    public $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.customer-registration',
            with: [
                'customer' => $this->customer,
            ],
        );
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: (__('Welcome ').$this->customer->name.' '.__('to').' '.settings('site_name')),
        );
    }
}
