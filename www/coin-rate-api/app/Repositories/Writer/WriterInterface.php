<?php

namespace App\Repositories\Writer;

use Illuminate\Support\Collection;

interface WriterInterface
{
    /**
     * Write the subscriptions to the destination.
     *
     * @param Collection $subscriptions
     * @return bool
     */
    public function write(Collection $subscriptions): bool;
}
