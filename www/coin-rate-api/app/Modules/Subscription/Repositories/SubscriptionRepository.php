<?php

namespace App\Modules\Subscription\Repositories;

use App\Modules\Subscription\Repositories\Reader\ReaderInterface;
use App\Modules\Subscription\Repositories\Writer\WriterInterface;
use Illuminate\Support\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    public function __construct(private ReaderInterface $reader, private WriterInterface $writer)
    {
    }

    public function all(): Collection
    {
        return $this->reader->read();
    }

    public function save(Collection $subscriptions): bool
    {
        return $this->writer->write($subscriptions);
    }
}
