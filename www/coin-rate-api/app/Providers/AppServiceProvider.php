<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\CoinRateService;
use App\Services\CoinRateServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CoinRateServiceInterface::class, CoinRateService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
