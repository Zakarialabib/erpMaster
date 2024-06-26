<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReturnPurchaseMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public $returnPurchaseMail, public $pdf)
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Return Purchase Details - '.settings('company_name'))
            ->markdown('emails.returnPurchaseMail')
            ->attachData($this->pdf, 'Return_'.$this->returnPurchaseMail['reference'].'.pdf', [
                'mime' => 'application/pdf',
            ])
            ->with('data', $this->returnPurchaseMail);
    }
}
