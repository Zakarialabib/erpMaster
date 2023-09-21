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

    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from((settings('company_email') ?? 'noreply@'.request()->getHost()), settings('site_name'))
            ->replyTo(request()->input('email'))
            ->subject(__('Thank you for your subscription').settings('site_mame'))
            ->markdown('vendor.notifications.email', [
                'introLines' => [__('We will get you updated once we will.')],
            ]);
    }
}
