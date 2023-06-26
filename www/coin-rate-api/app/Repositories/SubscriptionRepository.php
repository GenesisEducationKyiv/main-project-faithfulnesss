<?php

namespace App\Repositories;

use App\Repositories\Reader\ReaderInterface;
use App\Repositories\Writer\WriterInterface;
use Illuminate\Support\Collection;

class SubscriptionRepository implements SubscriptionRepositoryInterface
{
    private $reader;
    private $writer;

    public function __construct(ReaderInterface $reader, WriterInterface $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * Get all subscriptions.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->reader->read();
    }

    /**
     * Save the given subscriptions.
     *
     * @param Collection $subscriptions
     * @return bool
     */
    public function save(Collection $subscriptions): bool
    {
        return $this->writer->write($subscriptions);
    }
}
