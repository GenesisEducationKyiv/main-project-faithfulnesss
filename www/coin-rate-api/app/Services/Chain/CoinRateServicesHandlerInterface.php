<?php

namespace App\Services\Chain;

use App\Services\Utilities\Currencies;

interface CoinRateServicesHandlerInterface
{
    public function setNext(CoinRateServicesHandlerInterface $handler): CoinRateServicesHandlerInterface;

    public function getRate(Currencies $from, Currencies $to): ?float;
}
