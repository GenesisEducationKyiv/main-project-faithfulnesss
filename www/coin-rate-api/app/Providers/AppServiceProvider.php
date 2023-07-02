<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use App\Services\CoinMarketCapRateService;
use App\Services\CoinRateServiceInterface;
use App\Services\BinanceRateService;
use App\Services\Decorators\CoinRateServiceLoggingDecorator;
use App\Services\Chain\CoinRateServicesHandler;
use App\Services\Chain\CoinRateServicesHandlerInterface;

use App\Repositories\SubscriptionRepository;
use App\Repositories\SubscriptionRepositoryInterface;

use App\Repositories\Reader\FileReader;
use App\Repositories\Reader\ReaderInterface;

use App\Repositories\Writer\FileWriter;
use App\Repositories\Writer\WriterInterface;


class AppServiceProvider extends ServiceProvider
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
        
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);

        $this->app->bind(ReaderInterface::class, function () {
            $path = Config::get('database.file_storage.path');             
            return new FileReader($path);
        });

        $this->app->bind(WriterInterface::class, function () {
            $path = Config::get('database.file_storage.path');             
            return new FileWriter($path);
        });    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
