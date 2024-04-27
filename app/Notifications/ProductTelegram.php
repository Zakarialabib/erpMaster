<?php

declare(strict_types=1);

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class ProductTelegram extends Notification
{
    use Queueable;

    /** @return void */
    public function __construct(public mixed $telegramChannel, public mixed $productName, public mixed $productPrice)
    {
    }

    /** @return array<string> */
    public function via(mixed $notifiable): array
    {
        return ['telegram'];
    }

    /** @return TelegramMessage */
    public function toTelegram(mixed $notifiable)
    {
        return TelegramMessage::create()
            ->to($this->telegramChannel)
            ->content(sprintf('Check out our new product: %s for %s', $this->productName, $this->productPrice));
    }

    /** Get the array representation of the notification. */
    public function toArray(mixed $notifiable): array
    {
        return [
            'product_name'  => $this->productName,
            'product_price' => $this->productPrice,
        ];
    }
}
