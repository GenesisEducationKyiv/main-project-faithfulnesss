<?php

namespace App\Modules\Mailing\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

use App\Modules\Mailing\Mail\RateMail;

class MailingService implements MailingServiceInterface
{
    public function sendEmail(Collection $subscriptions, float $rate): void
    {
        foreach ($subscriptions as $subscription) {
            Mail::to($subscription->email)->send(new RateMail($rate));
        }
    }
}
