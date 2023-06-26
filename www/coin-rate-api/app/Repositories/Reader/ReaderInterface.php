<?php

namespace App\Repositories\Reader;

use Illuminate\Support\Collection;

interface ReaderInterface
{
    /**
     * Read the subscriptions from the source.
     *
     * @return Collection
     */
    public function read(): Collection;
}
