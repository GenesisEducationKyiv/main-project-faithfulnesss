<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

use App\Services\Chain\CoinRateServicesHandlerInterface;

use App\Services\Utilities\Currencies;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class CoinRateController
 */
class CoinRateController extends Controller
{

    public function __construct(private CoinRateServicesHandlerInterface $coinRateServiceHandler)
    {
    }

    public function getRate(): JsonResponse
    {
        $rate = $this->coinRateServiceHandler->getRate(Currencies::BTC, Currencies::UAH);

        if (empty($rate)) {
            return response()->json(['msg' => 'Failed to fetch the BTC-UAH rate.'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['rate' => $rate], Response::HTTP_OK);
    }
}
