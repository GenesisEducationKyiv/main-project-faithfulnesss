<?php

namespace App\Services\Decorators;

use App\Services\Utilities\Currencies;
use App\Services\Loggers\LoggerInterface;
use App\Services\CoinRateServiceInterface;

use Illuminate\Http\Client\Response;

class CoinRateServiceLoggingDecorator extends CoinRateServiceBaseDecorator
{

    public function __construct(
        private LoggerInterface $logger,
        CoinRateServiceInterface $service
    ) { 
        parent::__construct($service);
    }


    public function makeRequest(Currencies $from, Currencies $to) : Response 
    {
        $response = parent::makeRequest($from, $to);

        $this->logger->log('Request ' . $this->serviceName . 
        '\n' . implode(['response' => $response->body()]));
        
        return $response;
    }

}
