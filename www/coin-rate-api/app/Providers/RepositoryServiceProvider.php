<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

use App\Modules\Subscription\Repositories\SubscriptionRepository;
use App\Modules\Subscription\Repositories\SubscriptionRepositoryInterface;

use App\Modules\Subscription\Repositories\Reader\FileReader;
use App\Modules\Subscription\Repositories\Reader\ReaderInterface;
use App\Modules\Subscription\Repositories\Writer\FileWriter;
use App\Modules\Subscription\Repositories\Writer\WriterInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

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
}
