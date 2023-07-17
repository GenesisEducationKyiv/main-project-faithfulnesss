<?php

namespace App\Modules\Subscription\Entities;

use Illuminate\Notifications\Notifiable;

class Subscription
{
    use Notifiable;

    public string $email;
    public string $subscriptionDate;

    public function __construct(string $email, string $subscriptionDate)
    {
        $this->email = $email;
        $this->subscriptionDate = $subscriptionDate;
    }
}
