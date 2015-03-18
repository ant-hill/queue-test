<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 12:16
 */

namespace QueueTests\QueueDriver;


use Consumer;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQDriver implements DriverInterface
{
    /**
     * @var AMQPConnection
     */
    private $conn;

    /**
     * @var AMQPChannel[]
     */
    private $channels = [];

    public function __construct()
    {
        $exchange = 'bench_exchange';
        $queue = 'bench_queue';

        $conn = new AMQPConnection('localhost', 5672, 'guest', 'guest', '/');
        $this->conn = $conn;

        $ch = $conn->channel();

        $ch->queue_declare($queue, false, false, false, false);

        $ch->exchange_declare($exchange, 'direct', false, false, false);

        $ch->queue_bind($queue, $exchange);

    }

    public function subscribe($channel = "default")
    {
        // http://stackoverflow.com/questions/6340947/rabbitmq-basic-recover-doesnt-work
        /* @var $message \PhpAmqpLib\Message\AMQPMessage */
        $message =  $this->getChannel($channel)->basic_get($channel,true);
        if(!$message){
            return null;
        }
        return $message->body;
    }

    public function publish($channel, $message)
    {
        $msg = new AMQPMessage($message);

        $this->getChannel($channel)->basic_publish($msg, $channel);
    }

    /**
     * @param $channelName
     * @return \PhpAmqpLib\Channel\AMQPChannel
     */
    private function getChannel($channelName)
    {
        if (isset($this->channels[$channelName])) {
            return $this->channels[$channelName];
        }
        $queue = $exchange = $channelName;
        $conn = $this->conn;
        $ch = $conn->channel();
        $ch->queue_declare($queue, false, false, false, false);
        $ch->exchange_declare($exchange, 'direct', false, false, false);
        $ch->queue_bind($queue, $exchange);
        $this->channels[$channelName] = $ch;
        return $ch;
    }

    public function __destruct()
    {
        foreach ($this->channels as $ch) {
            $ch->close();
        }

        $this->conn->close();
    }
}