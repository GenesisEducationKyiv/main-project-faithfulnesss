<?php

namespace App\Services\Decorators;

use App\Services\CoinRateServiceInterface;
use App\Services\Utilities\Currencies;

use Illuminate\Http\Client\Response;

class CoinRateServiceBaseDecorator implements CoinRateServiceInterface
{
    protected $serviceName;

    public function __construct(private CoinRateServiceInterface $service)
    {
        $serviceClassName = get_class($service);

        $this->serviceName = substr($serviceClassName , 0, strpos($serviceClassName , "Rate"));
    }

    public function getRate(Currencies $from, Currencies $to) : ?float 
    {
        return $this->service->getRate($from, $to);
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
