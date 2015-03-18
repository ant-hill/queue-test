<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:40
 */

namespace QueueTests\QueueDriver;


interface DriverInterface {

    /**
     * @param string $channel
     * @return mixed
     */
    public function subscribe($channel="default");

    /**
     * @param $channel
     * @param $message
     * @return mixed
     */
    public function publish($channel, $message);
}