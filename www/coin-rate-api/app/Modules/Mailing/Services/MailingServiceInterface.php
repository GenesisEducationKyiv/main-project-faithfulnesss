<?php

namespace App\Modules\Mailing\Services;

use Illuminate\Support\Collection;

interface MailingServiceInterface
{
    public function sendEmail(Collection $subscriptions, float $rate): void;
}
