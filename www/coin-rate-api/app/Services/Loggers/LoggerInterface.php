<?php

namespace App\Services\Loggers;

interface LoggerInterface
{
    public function log(string $message): void;
}
