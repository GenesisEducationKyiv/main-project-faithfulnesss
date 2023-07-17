<?php

namespace App\Modules\Subscription\Repositories\Writer;

use Illuminate\Support\Collection;

interface WriterInterface
{
    /**
     * Write the subscriptions to the destination.
     *
     */
    public function write(Collection $subscriptions): bool;
}
