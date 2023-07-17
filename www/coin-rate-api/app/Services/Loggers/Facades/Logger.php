<?php

namespace App\Services\Loggers\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\Loggers\LoggerInterface;

class Logger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LoggerInterface::class;
    }
}
