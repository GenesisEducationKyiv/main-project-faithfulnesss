<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\SubscriptionController;
use App\Models\Subscription;
use App\Services\CoinRateServiceInterface;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionControllerTest extends TestCase
{
    private $coinRateService;
    private $subscriptionController;

    public function setUp(): void
    {
        parent::setUp();

        $this->coinRateService = \Mockery::mock(CoinRateServiceInterface::class);
        $this->subscriptionController = new SubscriptionController($this->coinRateService);
    }

    public function testStore()
    {
        
        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('input')
            ->with('email')
            ->andReturn('test@example.com');

        $request->shouldReceive('all')
            ->andReturn(['email' => 'test@example.com']);

        Storage::fake('subscriptions');

        $response = $this->subscriptionController->store($request);

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals('Email successfully created', $response->getData()->msg);

        Storage::disk('local')->assertExists('subscriptions.json');
    }

    public function testSendEmailsSuccess(): void
    {
        Notification::fake();
    
        $rate = 100;
    
        $this->coinRateService
            ->shouldReceive('getRate')
            ->once()
            ->andReturn($rate);
    
        $subscription = new Subscription(['email' => 'test@example.com']);
    
        Storage::shouldReceive('get')
        ->once()
        ->with('subscriptions.json')
        ->andReturn(json_encode([
            [
                'email' => 'test@example.com',
                'subscription_date' => '2023-01-01'
            ]
        ]));
    
        $response = $this->subscriptionController->sendEmails();
    
        $this->assertEquals('Emails have been successfully sent', $response->getData()->msg);
    
        Notification::assertSentTo(
            [$subscription],
            \App\Notifications\CoinRateNotification::class,
            function ($notification, $channels) use ($rate) {
                return $notification->rate === $rate;
            }
        );
    }
}
