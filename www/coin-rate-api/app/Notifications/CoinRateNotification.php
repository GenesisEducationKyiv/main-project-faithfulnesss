<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CoinRateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $rate;

    public function __construct($rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the notification's delivery channels.
     *
     */
    public function via(): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return (new MailMessage)
            ->line('BTC/UAH Rate Update.')
            ->line('Current BTC/UAH rate is 1 BTC = ' . $this->rate . " UAH")
            ->line('Thank you for subscribing for our services!');
    }
}
