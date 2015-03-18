<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:58
 */

namespace QueueTests\Tests;


use QueueTests\Queue\QueueInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class RandomPublisherQueue
{


    /**
     * @param QueueInterface $queue
     */
    public function run(QueueInterface $queue)
    {
            $testMessage = uniqid("asd_");
            $queue->publish($testMessage);
    }

}