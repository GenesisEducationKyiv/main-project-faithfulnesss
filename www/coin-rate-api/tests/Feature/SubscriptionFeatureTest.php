<?php

namespace Tests\Feature;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionFeatureTest extends TestCase
{
    use WithFaker;

    public function testSubscriptionWorkflow()
    {
        $email = $this->faker->email;

        $response = $this->post('/api/subscribe', ['email' => $email]);
        $response->assertStatus(201);

        $subscriptions = Subscription::loadSubscriptions();

        $this->assertTrue($subscriptions->contains('email', $email));

        $response = $this->post('/api/sendEmails');
        $response->assertStatus(200);
    }
}
