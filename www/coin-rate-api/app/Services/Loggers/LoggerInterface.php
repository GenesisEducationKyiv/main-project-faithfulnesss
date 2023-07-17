<?php

namespace App\Services\Loggers;

interface LoggerInterface
{
    public function info(string $message): void;

    public function debug(string $message): void;
    
    public function error(string $message): void;
}
