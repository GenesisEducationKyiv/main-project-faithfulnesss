<?php

namespace App\Services\Decorators;

use App\Services\Utilities\Currencies;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class CoinRateServiceLoggingDecorator extends CoinRateServiceBaseDecorator
{
    public function makeRequest(Currencies $from, Currencies $to) : Response {
        $response = parent::makeRequest($from, $to);

        Log::info('Request ' . $this->serviceName . '\n', [
            'response' => $response->body(),
        ]);

        return $response;
    }

}
