<?php

namespace App\Modules\Subscription\Repositories;

use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    public function all(): Collection;

    public function save(Collection $subscriptions): bool;
}
