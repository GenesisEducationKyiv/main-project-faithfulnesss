<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use Symfony\Component\HttpFoundation\Response;

use App\Services\CoinRateServiceInterface;

    /**
     * Class CoinRateController
     */
class CoinRateController extends Controller
{
    private $coinRateService;
    
    /**
     * CoinRateController constructor.
     *
     * @param CoinRateServiceInterface $coinRateService parameter is typehinted with the CoinRateService class
     */

    public function __construct(CoinRateServiceInterface $coinRateService)
    {
        $this->coinRateService = $coinRateService;
    }
        
    /**
     * Get the current BTC-UAH rate.
     *
     * @return JsonResponse The JSON response with the rate from the CoinRateService
     */
    public function getRate()
    {
        // Call the CoinRateService to retrieve the current BTC-UAH rate
        $rate = $this->coinRateService->getRate('BTC', 'UAH');

        // If the rate is empty or unavailable, return an error response
        if(empty($rate)) {
            return response()->json(['msg' => 'Failed to fetch the BTC-UAH rate.'], Response::HTTP_BAD_REQUEST);            
        }

        // Return a successful response with the rate
        return response()->json(['rate' => $rate], Response::HTTP_OK);
    }
}
