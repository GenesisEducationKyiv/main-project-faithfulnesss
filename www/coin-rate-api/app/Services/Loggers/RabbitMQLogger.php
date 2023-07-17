<?php

namespace App\Services\Loggers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

use Illuminate\Support\Facades\Config;

class RabbitMQLogger implements LoggerInterface
{
    protected $connection;
    protected $channel;
    protected $queue;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $hosts_array = Config::get("queue.connections.rabbitmq.hosts.0"); 

        $this->connection = new AMQPStreamConnection(
            $hosts_array['host'],
            $hosts_array['port'],
            $hosts_array['user'],
            $hosts_array['password'],
        );

        $this->channel = $this->connection->channel();

        $this->queue = Config::get("queue.connections.rabbitmq.queue");

        $this->channel->queue_declare(
            $this->queue, // Queue name
            false, // Passive: If set to true, the server will reply with Declare-Ok if the queue already exists with the same name.
            true, // Durable: If set to true, the queue will survive broker restarts.
            false, // Exclusive: If set to true, the queue can only be accessed by the current connection.
            false // Auto-delete: If set to true, the queue will be deleted when the last consumer unsubscribes.
        );
    }

    public function info(string $message): void
    {
        $this->log("info", $message);
    }

    public function debug(string $message): void
    {
        $this->log("debug", $message);
    }

    public function error(string $message): void
    {
        $this->log("error", $message);
    }

    protected function log(string $level, string $message): void
    {
        $log = [
            "level" => $level,
            "message" => $message,
            "timestamp" => now()->toDateTimeString(),
        ];

        $logJson = json_encode($log);

        $message = new AMQPMessage($logJson);

        $this->channel->basic_publish(
            $message,  // object representing the message to be published
            "",       // Exchange name (empty string means default exchange)
            $this->queue // Routing key or queue name
        );
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
