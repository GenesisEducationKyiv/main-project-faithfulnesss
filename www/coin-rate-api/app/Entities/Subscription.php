<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;

class Subscription
{
    use Notifiable;

    public $email;
    public $subscriptionDate;

    public function __construct($email, $subscriptionDate)
    {
        $this->email = $email;
        $this->subscriptionDate = $subscriptionDate;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSubscriptionDate()
    {
        return $this->subscriptionDate;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setSubscriptionDate($subscriptionDate)
    {
        $this->subscriptionDate = $subscriptionDate;
    }
}
