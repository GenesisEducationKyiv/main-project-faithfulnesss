<?php

namespace App\Repositories\Writer;

use Illuminate\Support\Collection;

interface WriterInterface
{
    /**
     * Write the subscriptions to the destination.
     *
     */
    public function write(Collection $subscriptions): bool;
}
