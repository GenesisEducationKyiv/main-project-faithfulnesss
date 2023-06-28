<?php

namespace Tests\Integration;

use App\Models\Subscription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Tests\TestCase;

class SubscriptionIntegrationTest extends TestCase
{
    public function testLoadSubscriptions()
    {
        $subscriptions = new Collection([
            ['email' => 'test1@example.com', 'subscription_date' => '2023-06-18'],
            ['email' => 'test2@example.com', 'subscription_date' => '2023-06-19'],
        ]);

        Subscription::saveSubscriptions($subscriptions);

        $loadedSubscriptions = Subscription::loadSubscriptions();

        $this->assertEquals($subscriptions->toArray(), $loadedSubscriptions->toArray());
    }

    public function testSaveSubscriptions()
    {
        $subscriptions = new Collection([
            new Subscription(['email' => 'user1@example.com']),
            new Subscription(['email' => 'user2@example.com']),
        ]);

        $result = Subscription::saveSubscriptions($subscriptions);

        $this->assertTrue($result);

        $contents = Storage::get('subscriptions.json');
        $loadedSubscriptions = collect(json_decode($contents, true) ?? []);

        $this->assertEquals($subscriptions->toArray(), $loadedSubscriptions->toArray());
    }
}
