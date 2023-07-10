<?php

namespace App\Services\Chain;

use App\Services\CoinRateServiceInterface;
use App\Services\Utilities\Currencies;

class CoinRateServicesHandler extends AbstractCoinRateServicesHandler
{

    public function __construct(private CoinRateServiceInterface $service)
    { }

    public function getRate(Currencies $from, Currencies $to) : ?float 
    {    
        $request = $this->service->makeRequest($from, $to); 

        if($request->status() === 200)
        {
            return $this->service->decodeResponse($request, $from, $to);
        }

        return parent::getRate($from, $to);
    }

}
