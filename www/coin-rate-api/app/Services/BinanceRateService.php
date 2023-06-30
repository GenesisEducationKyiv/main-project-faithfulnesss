<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\Response;

use App\Services\Utilities\Currencies;

/**
 * Class CoinMarketCapRateService
 *
 * Service class for retrieving coin rate from a third-party API (in this case CoinMarketCap API).
 */
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
        // Extract the response body and decode it from JSON
        $data = $response->json();

        // Access the necessary data in the response to retrieve the coin rate
        // If the @json_decode fails or the necessary data is not available 
        // set the rate to null
        $rate = $data['price'] ?? null;

        return $rate;
    }

    public function makeRequest(Currencies $from, Currencies $to): Response 
    {
        // Send a GET request to the third-party API endpoint with the required auth header 
        // and parameters for BTC-UAH rate
        $response = Http::get($this->apiUri, ['symbol' => $from->value . $to->value]);

        return $response;
    }
}
