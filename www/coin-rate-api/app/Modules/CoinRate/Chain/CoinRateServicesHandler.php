<?php

namespace App\Modules\CoinRate\Chain;

use App\Modules\CoinRate\Services\CoinRateServiceInterface;
use App\Modules\CoinRate\Utilities\Currencies;

use App\Jobs\TestJob;

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
