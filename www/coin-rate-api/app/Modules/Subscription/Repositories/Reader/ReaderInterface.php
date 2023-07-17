<?php

namespace App\Modules\Subscription\Repositories\Reader;

use Illuminate\Support\Collection;

interface ReaderInterface
{
    /**
     * Read the subscriptions from the source.
     *
     */
    public function read(): Collection;
}
