<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:58
 */

namespace QueueTests\Tests;


use QueueTests\Queue\QueueInterface;

class RandomSubscriberQueue
{


    /**
     * @param QueueInterface $queue
     * @param int $max
     */
    public function run(QueueInterface $queue, $max = 10)
    {
        while ($max--) {
            $queue->subscribe();
        }
    }

}