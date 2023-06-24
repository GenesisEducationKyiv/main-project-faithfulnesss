<?php

namespace Tests\Unit;

use App\Http\Controllers\CoinRateController;
use App\Services\CoinRateServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Mockery;

class CoinRateControllerTest extends TestCase
{
    private $coinRateService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coinRateService = Mockery::mock(CoinRateServiceInterface::class);
    }

    public function testGetRateSuccess()
    {
        $controller = new CoinRateController($this->coinRateService);

        $expectedRate = 3000;
        $this->coinRateService->shouldReceive('getRate')
            ->once()
            ->with('BTC', 'UAH')
            ->andReturn($expectedRate);

        $response = $controller->getRate();

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($expectedRate, $response->getData()->rate);
    }

    public function testGetRateFailure()
    {
        $controller = new CoinRateController($this->coinRateService);

        $this->coinRateService->shouldReceive('getRate')
            ->once()
            ->with('BTC', 'UAH')
            ->andReturn(null);

        $response = $controller->getRate();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals('Failed to fetch the BTC-UAH rate.', $response->getData()->msg);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
