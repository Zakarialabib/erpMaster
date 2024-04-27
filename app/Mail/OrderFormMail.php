<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\OrderForms;
use Illuminate\Mail\Mailables\Envelope;

class OrderFormMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /** @var OrderForms */
    public $order;

    public function __construct(OrderForms $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('emails.order-form')
            ->subject(__('New Order Form!').$this->order->name)
            ->with([
                'order' => $this->order,
            ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: sprintf('Welcome, %s!', $this->order->name),
        );
    }
}
