<?php

namespace App\Services\Loggers;

class FileLogger implements LoggerInterface
{
    protected $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function info(string $message): void
    {
        $this->log('INFO', $message);
    }

    public function debug(string $message): void
    {
        $this->log('DEBUG', $message);
    }

    public function error(string $message): void
    {
        $this->log('ERROR', $message);
    }

    protected function log(string $level, string $message): void
    {
        $formattedMessage = date('Y-m-d H:i:s') . ' [' . $level . '] ' . $message . PHP_EOL;
        file_put_contents($this->path, $formattedMessage, FILE_APPEND | LOCK_EX);
    }
}
