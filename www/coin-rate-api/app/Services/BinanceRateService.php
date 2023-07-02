<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\Response;

use App\Services\Utilities\Currencies;

class BinanceRateService implements CoinRateServiceInterface
{
    private $apiUri;

    public function __construct()
    {
        $this->apiUri = Config::get('services.binance.api_uri');
    }

    public function getRate(Currencies $from, Currencies $to): ?float 
    {
        $response = $this->makeRequest($from, $to);

        return $this->decodeResponse($response, $from, $to);
    }

    public function decodeResponse(Response $response, Currencies $from, Currencies $to): ?float 
    {
        $data = $response->json();

        $rate = $data['price'] ?? null;

        return $rate;
    }

    public function makeRequest(Currencies $from, Currencies $to): Response 
    {
        $response = Http::get($this->apiUri, ['symbol' => $from->value . $to->value]);

        return $response;
    }
}
