<?php

namespace App\Modules\CoinRate\Chain;

use App\Modules\CoinRate\Utilities\Currencies;

abstract class AbstractCoinRateServicesHandler implements CoinRateServicesHandlerInterface
{
    private $nextHandler;

    public function setNext(CoinRateServicesHandlerInterface $handler): CoinRateServicesHandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function getRate(Currencies $from, Currencies $to): ?float
    {
        if ($this->nextHandler) 
        {
            return $this->nextHandler->getRate($from, $to);
        }

        return null;
    }
}
