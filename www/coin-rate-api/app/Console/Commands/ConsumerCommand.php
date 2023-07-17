<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumerCommand extends Command
{
    protected $signature = 'rabbitmq:consumer';

    protected $description = 'RabbitMQ Consumer';

    public function handle() 
    {
        $hosts_array = Config::get("queue.connections.rabbitmq.hosts.0"); 

        $connection = new AMQPStreamConnection(
            $hosts_array['host'],
            $hosts_array['port'],
            $hosts_array['user'],
            $hosts_array['password'],
        );

        $channel = $connection->channel();

        $queue = Config::get("queue.connections.rabbitmq.queue");

        $channel->queue_declare(
            $queue, // Queue name
            false, // Passive: If set to true, the server will reply with Declare-Ok if the queue already exists with the same name.
            true, // Durable: If set to true, the queue will survive broker restarts.
            false, // Exclusive: If set to true, the queue can only be accessed by the current connection.
            false // Auto-delete: If set to true, the queue will be deleted when the last consumer unsubscribes.
        );

        echo "Waiting for messages. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo "Received message:\n";
            print_r($msg->body);
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $channel->basic_qos(
            null, // Prefetch size: null means no specific prefetch size
            1,    // Prefetch count: the maximum number of unacknowledged messages to deliver to this consumer at a time
            null  // Global flag: null means the QoS settings apply per-consumer, not globally
        );

        $channel->basic_consume(
            'default',  // Queue name to consume messages from
            '',         // Consumer tag (empty string for auto-generated tag)
            false,      // No auto-acknowledgment of messages
            false,      // Non-exclusive consumer access to the queue
            false,      // No auto-delete of the consumer when not in use
            false,      // No consumer-specific arguments
            $callback   // Callback function to handle received messages
        );
        
        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();

        return Command::SUCCESS;
    }
}
