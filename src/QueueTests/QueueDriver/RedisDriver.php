<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:41
 */

namespace QueueTests\QueueDriver;


class RedisDriver implements DriverInterface
{
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('localhost');
    }

    public function subscribe($channel = "default")
    {
        return $this->redis->lPop($channel);
    }

    public function publish($channel, $message)
    {
        return $this->redis->rPush($channel, $message);
    }
}