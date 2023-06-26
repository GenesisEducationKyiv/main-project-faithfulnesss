<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    /**
     * Get all subscriptions.
     *
     */
    public function all(): Collection;

    /**
     * Save the given subscriptions.
     *
     */
    public function save(Collection $subscriptions): bool;
}
