<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceModeNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $status;

    public function __construct(bool $status)
    {
        $this->status = $status;
    }

    /** Get the message envelope. */
    public function envelope(): Envelope
    {
        $subject = $this->status ? 'Maintenance Mode Enabled' : 'Maintenance Mode Disabled';

        return new Envelope(
            subject: $subject,
        );
    }

    /** Get the message content definition. */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.maintenance-mode',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments(): array
    {
        return [];
    }
}
