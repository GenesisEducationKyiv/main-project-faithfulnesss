<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Config;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Mockery;
use App\Models\Subscription;
use App\Notifications\CoinRateNotification;
use App\Services\CoinRateServiceInterface;

class CoinRateIntegrationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $mockService = Mockery::mock(CoinRateServiceInterface::class);
        $mockService->shouldReceive('getRate')
            ->andReturn(50000.00);
        $this->app->instance(CoinRateServiceInterface::class, $mockService);

        Notification::fake();
    }

    public function testCoinRateControllerUsesServiceCorrectly()
    {
        $response = $this->get('/api/rate');
        $response->assertStatus(200);
        $response->assertJson(['rate' => 50000.00]);
    }

    public function testSubscriptionControllerUsesServiceCorrectly()
    {
        $response = $this->post('/api/sendEmails'); 
        $response->assertStatus(200);
        $response->assertJson(['msg' => 'Emails have been successfully sent']);

        Notification::assertSentTo(
            Subscription::loadSubscriptions(), 
            function (CoinRateNotification $notification, $channels) {
                return $notification->rate === 50000.00;
            }
        );
    }
}
