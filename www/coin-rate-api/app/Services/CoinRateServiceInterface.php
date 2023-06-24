<?php

namespace App\Services;

interface CoinRateServiceInterface 
{

    public function getRate(string $from, string $to);

}