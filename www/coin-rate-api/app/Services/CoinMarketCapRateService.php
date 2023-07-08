<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\Response;

use App\Services\Utilities\Currencies;

class CoinMarketCapRateService implements CoinRateServiceInterface
{
    private $apiKey;
    private $apiUri;

    public function __construct()
    {
        $this->apiKey = Config::get('services.cmp.token');
        $this->apiUri = Config::get('services.cmp.api_uri');
    }

    public function getRate(Currencies $from, Currencies $to): ?float 
    {
        $response = $this->makeRequest($from, $to);

        return $this->decodeResponse($response, $from, $to);
    }

    public function decodeResponse(Response $response, Currencies $from, Currencies $to): ?float 
    {
        $data = $response->json();

        $rate = $data['data'][$from->value]['quote'][$to->value]['price'] ?? null;

        return $rate;
    }

    public function makeRequest(Currencies $from, Currencies $to): Response 
    {
        $response = Http::withHeaders(
            [
                'X-CMC_PRO_API_KEY' => $this->apiKey,
            ]
        )->get(
            $this->apiUri . 'cryptocurrency/quotes/latest',
            [
                'symbol' => $from->value,
                'convert' => $to->value,
            ]
        );

        return $response;
    }
}