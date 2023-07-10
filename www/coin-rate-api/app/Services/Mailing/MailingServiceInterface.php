<?php

namespace App\Services\Mailing;

use Illuminate\Mail\SentMessage;
use Illuminate\Support\Collection;

interface MailingServiceInterface
{
    public function sendEmail(Collection $subscriptions, float $rate): void;
}
