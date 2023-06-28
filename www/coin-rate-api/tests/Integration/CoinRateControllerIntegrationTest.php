<?php

namespace Tests\Integration;

use Tests\TestCase;
use App\Services\CoinRateServiceInterface;
use Mockery;

class CoinRateControllerIntegrationTest extends TestCase
{
    public function testGetRateReturnsValidResponse()
    {
        $coinRateService = Mockery::mock(CoinRateServiceInterface::class);
        
        $expectedRate = 5000;
        
        $coinRateService->shouldReceive('getRate')
            ->once()
            ->with('BTC', 'UAH')
            ->andReturn($expectedRate);

        $this->app->instance(CoinRateServiceInterface::class, $coinRateService);

        $response = $this->get('/api/rate');

        $response->assertStatus(200);

        $response->assertJson(['rate' => $expectedRate]);
    }
}
