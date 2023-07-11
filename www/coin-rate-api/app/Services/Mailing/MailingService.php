<?php

namespace App\Services\Mailing;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Collection;

use App\Mail\RateMail;

class MailingService implements MailingServiceInterface
{
    public function sendEmail(Collection $subscriptions, float $rate): void
    {
        foreach ($subscriptions as $subscription) {
            Mail::to($subscription->email)->send(new RateMail($rate));
        }
    }
}
