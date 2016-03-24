<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 12:16
 */

namespace QueueTests\QueueDriver;


class RabbitMQPeclDriver implements DriverInterface
{
    /**
     * @var \AMQPConnection
     */
    private $conn;

    /**
     * @var \AMQPExchange[]
     */
    private $exchanges = [];

    /**
     * @var \AMQPQueue[]
     */
    private $queues = [];

    public function __construct()
    {
        $conn = new \AMQPConnection();
        $conn->connect();
        $this->conn = $conn;
    }

    public function subscribe($channel = "default")
    {
        $message =  $this->getQueue($channel)->get(AMQP_AUTOACK);
        if(!$message){
            return null;
        }

        return $message->getBody();
    }

    public function publish($channel, $message)
    {
        $this->getExchange($channel)->publish($message);
    }

    /**
     * @param $channelName
     * @return \AMQPExchange
     */
    private function getExchange($channelName)
    {
        if (isset($this->exchanges[$channelName])) {
            return $this->exchanges[$channelName];
        }
        $queueName = $exchange = $channelName;

        $channel = new \AMQPChannel($this->conn);
        $ex = new \AMQPExchange($channel);
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setName($exchange);

        $ex->declareExchange();
        $queue = new \AMQPQueue($ex->getChannel());
        $queue->setName($queueName);
        $queue->declareQueue();
        $queue->bind($ex->getName());

        $this->exchanges[$channelName] = $ex;

        return $ex;
    }

    /**
     * @param $channelName
     * @return \AMQPQueue
     */
    private function getQueue($channelName)
    {
        if (isset($this->queues[$channelName])) {
            return $this->queues[$channelName];
        }
        $queueName = $exchange = $channelName;

        $channel = new \AMQPChannel($this->conn);
        $ex = new \AMQPExchange($channel);
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setName($exchange);

        $ex->declareExchange();
        $queue = new \AMQPQueue($ex->getChannel());
        $queue->setName($queueName);
        $queue->declareQueue();
        $queue->bind($ex->getName());

        $this->queues[$channelName] = $queue;
        return $queue;
    }

    public function __destruct()
    {
//        foreach ($this->channels as $ch) {
//            $ch->close();
//        }
//
//        $this->conn->close();
    }
}