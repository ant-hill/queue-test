<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:39
 */

namespace QueueTests\Queue;


class Queue extends AbstractQueue
{

    /**
     * @param mixed $message
     */
    public function publish($message)
    {
        return $this->driver->publish($this->channel, $message);
    }

    /**
     * @return mixed
     */
    public function subscribe()
    {
        return $this->driver->subscribe($this->channel);
    }
}