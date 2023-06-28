<?php

namespace Tests\Unit;

use App\Models\Subscription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

use Tests\TestCase;

class SubscriptionTest extends TestCase
{

    public function testLoadSubscriptionsReturnsCollectionOfSubscriptionObjects()
    {
        $subscriptionsData = [
            ['email' => 'test1@example.com', 'subscription_date' => '2023-06-18'],
            ['email' => 'test2@example.com', 'subscription_date' => '2023-06-19'],
        ];
        Storage::put('subscriptions.json', json_encode($subscriptionsData));

        $subscriptions = Subscription::loadSubscriptions();

        $this->assertInstanceOf(Collection::class, $subscriptions);
        $this->assertCount(2, $subscriptions);
        $this->assertInstanceOf(Subscription::class, $subscriptions[0]);
        $this->assertEquals('test1@example.com', $subscriptions[0]->email);
        $this->assertEquals('2023-06-18', $subscriptions[0]->subscription_date);
        $this->assertInstanceOf(Subscription::class, $subscriptions[1]);
        $this->assertEquals('test2@example.com', $subscriptions[1]->email);
        $this->assertEquals('2023-06-19', $subscriptions[1]->subscription_date);
    }

    public function testSaveSubscriptionsSavesCollectionToStorageFile()
    {
        $subscriptionsData = [
            ['email' => 'test1@example.com', 'subscription_date' => '2023-06-18'],
            ['email' => 'test2@example.com', 'subscription_date' => '2023-06-19'],
        ];
        $subscriptions = collect($subscriptionsData);

        $result = Subscription::saveSubscriptions($subscriptions);

        $this->assertTrue($result);
        $this->assertFileExists(storage_path('app/subscriptions.json'));
        $this->assertEquals($subscriptions->toJson(), Storage::get('subscriptions.json'));
    }
}
