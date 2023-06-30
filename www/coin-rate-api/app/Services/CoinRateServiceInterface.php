<?php

namespace App\Services;

use Illuminate\Http\Client\Response;

use App\Services\Utilities\Currencies;

interface CoinRateServiceInterface 
{

    public function getRate(Currencies $from, Currencies $to) : ?float;

    public function decodeResponse(Response $response, Currencies $from, Currencies $to) : ?float;

    public function makeRequest(Currencies $from, Currencies $to) : Response;
}