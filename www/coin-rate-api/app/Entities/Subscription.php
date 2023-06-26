<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;

class Subscription
{
    use Notifiable;

    public $email;
    public $subscriptionDate;

    public function __construct(string $email, string $subscriptionDate)
    {
        $this->email = $email;
        $this->subscriptionDate = $subscriptionDate;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getSubscriptionDate() : string
    {
        return $this->subscriptionDate;
    }

    public function setEmail(string $email) : void
    {
        $this->email = $email;
    }

    public function setSubscriptionDate(string $subscriptionDate) : void
    {
        $this->subscriptionDate = $subscriptionDate;
    }
}
