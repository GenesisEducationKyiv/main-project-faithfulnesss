<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    public function all(): Collection;

    public function save(Collection $subscriptions): bool;
}
