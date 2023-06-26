<?php

namespace App\Repositories;

use Illuminate\Support\Collection;

interface SubscriptionRepositoryInterface
{
    /**
     * Get all subscriptions.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Save the given subscriptions.
     *
     * @param Collection $subscriptions
     * @return bool
     */
    public function save(Collection $subscriptions): bool;
}
