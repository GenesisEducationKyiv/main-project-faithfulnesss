<?php

namespace App\Modules\CoinRate\Decorators;

use App\Modules\CoinRate\Utilities\Currencies;
use App\Modules\CoinRate\Services\CoinRateServiceInterface;

use App\Services\Loggers\LoggerInterface;

use App\Services\Loggers\Facades\Logger;

use Illuminate\Http\Client\Response;

class CoinRateServiceLoggingDecorator extends CoinRateServiceBaseDecorator
{

    public function __construct(
        // private LoggerInterface $logger,
        CoinRateServiceInterface $service
    ) { 
        parent::__construct($service);
    }


    public function makeRequest(Currencies $from, Currencies $to) : Response 
    {
        $response = parent::makeRequest($from, $to);

        Logger::info('Request ' . $this->serviceName . 
        '\n' . implode(['response' => $response->body()]));

        // $this->logger->info('Request ' . $this->serviceName . 
        // '\n' . implode(['response' => $response->body()]));
        
        return $response;
    }

}
