<?php

namespace App\Repositories;

use App\Repositories\Reader\ReaderInterface;
use App\Repositories\Writer\WriterInterface;
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
