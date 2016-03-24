<?php

namespace QueueTests\QueueDriver;


use Bunny\Client as BunnyClient;

class BunnyDriver implements DriverInterface
{
    /**
     * @var BunnyClient
     */
    private $client;

    /**
     * @var \Bunny\Channel[]
     */
    private $channels = [];

    public function __construct()
    {
        $client = new BunnyClient();
        $this->client = $client;
        $client->connect();
    }

    /**
     * @param string $channel
     * @return mixed
     */
    public function subscribe($channel = "default")
    {
        $message = $this->getChannel($channel)->get($channel, true);
        if(!$message){
            return null;
        }
        return $message;
        // TODO: Implement subscribe() method.
    }

    /**
     * @param $channel
     * @param $message
     * @return mixed
     */
    public function publish($channel, $message)
    {
        $this->getChannel($channel)->publish($message,[],$channel);
    }

    /**
     * @param $channelName
     * @return \Bunny\Channel|\React\Promise\PromiseInterface
     */
    private function getChannel($channelName)
    {
        if (isset($this->channels[$channelName])) {
            return $this->channels[$channelName];
        }
        $queue = $exchange = $channelName;
        $conn = $this->client;
        $ch = $conn->channel();

        $ch->queueDeclare($queue, false, false, false, false);
        $ch->exchangeDeclare($exchange, 'direct', false, false, false);
        $ch->queueBind($queue, $exchange);

        $this->channels[$channelName] = $ch;

        return $ch;
    }


    public function __destruct()
    {
        $this->client->disconnect();
    }
}