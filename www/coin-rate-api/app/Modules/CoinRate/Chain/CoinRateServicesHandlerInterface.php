<?php

namespace App\Modules\CoinRate\Chain;

use App\Modules\CoinRate\Utilities\Currencies;

interface CoinRateServicesHandlerInterface
{
    public function setNext(CoinRateServicesHandlerInterface $handler): CoinRateServicesHandlerInterface;

    public function getRate(Currencies $from, Currencies $to): ?float;
}
