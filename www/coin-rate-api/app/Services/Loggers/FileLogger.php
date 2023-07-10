<?php

namespace App\Services\Loggers;

use Illuminate\Support\Facades\Log;

class FileLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        Log::info($message);
    }
}
