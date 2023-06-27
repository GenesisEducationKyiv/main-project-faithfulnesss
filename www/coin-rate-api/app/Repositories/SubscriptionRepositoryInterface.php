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

    /**
     * Check whether email is already present in the source
     *
     */
    public function exists(string $email) : bool;
}
