<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use App\Modules\CoinRate\Services\CoinMarketCapRateService;
use App\Modules\CoinRate\Services\BinanceRateService;

use App\Modules\CoinRate\Decorators\CoinRateServiceLoggingDecorator;

use App\Modules\CoinRate\Chain\CoinRateServicesHandler;
use App\Modules\CoinRate\Chain\CoinRateServicesHandlerInterface;

use App\Services\Loggers\FileLogger;
use App\Services\Loggers\LoggerInterface;

class CoinRateServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->bind(CoinRateServicesHandlerInterface::class, function () {

            $coinMarketCapLoggedService = new CoinRateServiceLoggingDecorator(new CoinMarketCapRateService());
            $binanceLoggedService = new CoinRateServiceLoggingDecorator(new BinanceRateService());


            $handler = new CoinRateServicesHandler($coinMarketCapLoggedService);
            $handler->setNext(new CoinRateServicesHandler($binanceLoggedService));

            return $handler;
        });

        $this->app->bind(MailingServiceInterface::class, MailingService::class);
    }
}
