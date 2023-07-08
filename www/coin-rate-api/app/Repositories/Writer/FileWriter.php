<?php

namespace App\Repositories\Writer;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Entities\Subscription;

class FileWriter implements WriterInterface {
    
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    /**
     * Write the subscriptions to the file destination.
     *
     */
    public function write(Collection $subscriptions): bool
    {
        // Save the collection of Subscription model objects as a JSON
        // in the subscription.json file
        // return Storage::put(Config::get('database.file_storage.name'), $subscriptions->toJson());
        return Storage::put($this->path, $subscriptions->toJson());
    }
}
