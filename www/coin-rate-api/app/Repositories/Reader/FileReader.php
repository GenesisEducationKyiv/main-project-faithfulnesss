<?php

namespace App\Repositories\Reader;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Entities\Subscription;

class FileReader implements ReaderInterface
{
    private $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Read the subscriptions from the source.
     *
     * @return Collection
     */    
    public function read(): Collection
    {
        // Read the contents of the source file using Storage facade
        $contents = Storage::get($this->path);
        // Decode the JSON contents into a collection 
        // or use an empty array if decoding fails
        $subscriptions = collect(@json_decode($contents, true) ?? []);

        // Convert each array item to a Subscription object
        $subscriptions = $subscriptions->map(
            function ($item) {
                return new Subscription($item["email"], $item["subscriptionDate"]);
            }
        );

        // Return collection of Subscription model object
        return $subscriptions;
    }
}
