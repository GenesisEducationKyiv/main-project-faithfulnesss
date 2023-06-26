<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Services\CoinRateServiceInterface;
use App\Services\Utilities\Currencies;

use Symfony\Component\HttpFoundation\Response;

/**
* Class CoinRateController
*/
class CoinRateController extends Controller
{
    private $coinRateService;
    
    public function __construct(CoinRateServiceInterface $coinRateService)
    {
        $this->coinRateService = $coinRateService;
    }
        
    public function getRate() : JsonResponse
    {
        // Call the CoinRateService to retrieve the current BTC-UAH rate
        $rate = $this->coinRateService->getRate(Currencies::BTC, Currencies::UAH);

        // If the rate is empty or unavailable, return an error response
        if(empty($rate)) {
            return response()->json(['msg' => 'Failed to fetch the BTC-UAH rate.'], Response::HTTP_BAD_REQUEST);            
        }

        // Return a successful response with the rate
        return response()->json(['rate' => $rate], Response::HTTP_OK);
    }
}
