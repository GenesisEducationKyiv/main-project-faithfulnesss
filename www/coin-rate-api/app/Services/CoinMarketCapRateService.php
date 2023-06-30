<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

use App\Services\Utilities\Currencies;

/**
 * Class CoinMarketCapRateService
 *
 * Service class for retrieving coin rate from a third-party API (in this case CoinMarketCap API).
 */
class CoinMarketCapRateService implements CoinRateServiceInterface
{
    private $apiKey;
    private $apiUri;

    public function __construct()
    {
        $this->apiKey = Config::get('services.cmp.token');
        $this->apiUri = Config::get('services.cmp.api_uri');
    }

    public function getRate(Currencies $from, Currencies $to): float
    {
        // Send a GET request to the third-party API endpoint with the required auth header 
        // and parameters for BTC-UAH rate
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

        // Extract the response body and decode it from JSON
        // $data = @json_decode($response->json(), true);
        $data = $response->json();

        // Access the necessary data in the response to retrieve the coin rate
        // If the @json_decode fails or the necessary data is not available 
        // set the rate to null
        $rate = $data['data'][$from->value]['quote'][$to->value]['price'] ?? null;

        return $rate;
    }
}
