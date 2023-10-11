<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscribedMail extends Mailable
{
    use Queueable;
    use SerializesModels;

   /** Create a new message instance. */
   public function __construct(
    protected Subscriber $subscriber,
    ) {
    }

    /** Get the message envelope. */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(settings('company_email'), settings('site_title')),
            subject: $this->subscriber->name.' You are Subscribed to our Newsletters '.settings('site_title'),
        );
    }

    /** Get the message content definition. */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.subscribe-mail',
            with: [
                'subscriber' => $this->subscriber,
            ],
        );
    }
}
