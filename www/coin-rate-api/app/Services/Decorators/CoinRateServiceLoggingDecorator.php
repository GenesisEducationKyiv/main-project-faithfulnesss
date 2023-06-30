<?php

namespace App\Services\Decorators;

use App\Services\CoinRateServiceInterface;
use App\Services\Utilities\Currencies;


use Illuminate\Support\Facades\Log;

class CoinRateServiceLoggingDecorator extends CoinRateServiceBaseDecorator
{

    public function getRate(Currencies $from, Currencies $to) : ?float 
    {
        $response = parent::makeRequest($from, $to);

        Log::info('Request\n', [
            'response' => $response,
        ]);

        return parent::decodeResponse($response, $from, $to);

    }
}
