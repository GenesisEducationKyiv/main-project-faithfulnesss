<?php

namespace App\Services\Decorators;

use App\Services\CoinRateServiceInterface;
use App\Services\Utilities\Currencies;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class CoinRateServiceBaseDecorator implements CoinRateServiceInterface
{
    public function __construct(private CoinRateServiceInterface $service)
    {
    }

    public function getRate(Currencies $from, Currencies $to) : ?float 
    {
        $response = $this->service->makeRequest($from, $to);

        return $this->service->decodeResponse($response, $from, $to);

    }

    public function decodeResponse(Response $response, Currencies $from, Currencies $to) : ?float
    {
        return $this->service->decodeResponse($response, $from, $to);
    }

    public function makeRequest(Currencies $from, Currencies $to) : Response
    {
        return $this->service->makeRequest($from, $to);
    }
}
