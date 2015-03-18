<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:35
 */

namespace QueueTests\Queue;


use QueueTests\QueueDriver\DriverInterface;

abstract class AbstractQueue implements QueueInterface
{
    protected $channel;
    /**
     * @var DriverInterface
     */
    protected $driver;

    public function __construct(DriverInterface $driver, $channel = "default")
    {

        $this->channel = $channel;
        $this->driver = $driver;
    }

}