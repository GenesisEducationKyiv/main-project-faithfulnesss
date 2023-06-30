<?php

namespace App\Services;

use App\Services\Utilities\Currencies;

interface CoinRateServiceInterface 
{

    public function getRate(Currencies $from, Currencies $to) : float;

}