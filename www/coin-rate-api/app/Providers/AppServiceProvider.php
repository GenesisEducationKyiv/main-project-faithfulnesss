<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use App\Services\Loggers\FileLogger;
use App\Services\Loggers\RabbitMQLogger;
use App\Services\Loggers\LoggerInterface;

use App\Modules\Mailing\Services\MailingServiceInterface;
use App\Modules\Mailing\Services\MailingService;

use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $logger = new RabbitMQLogger();
        $logger->connect();

        $this->app->instance(LoggerInterface::class, $logger);

        $this->app->bind(MailingServiceInterface::class, MailingService::class);
    }
}
