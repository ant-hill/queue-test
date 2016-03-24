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

class ForeverSubscriberQueue
{


    /**
     * @param QueueInterface $queue
     * @param int $max
     */
    public function run(QueueInterface $queue, $max)
    {
        $stopwatch = new Stopwatch();

        $i = 0;
        $stopwatch->start("publish");
        while ($i < $max) {
            $testMessage = uniqid("asd_");
            $queue->publish($testMessage);
            $i++;
        }
        $stopwatch->stop("publish");
        $operationPerSec = round($i / $stopwatch->getEvent("publish")->getDuration() * 1000, 4);
        echo "publish " . $stopwatch->getEvent("publish")->getDuration() / 1000 . ' second $i: ' . $i . " op/s {$operationPerSec} memory: " . $stopwatch->getEvent("publish")->getMemory() / 1024 / 1024 . "\n\n";
        $q = $i;
        $stopwatch->start("subscribe");
        while ($x = $queue->subscribe($testMessage)) {
//            var_dump($x);
            $i--;
        }
        $stopwatch->stop("subscribe");

        $operationPerSec = round(($q - $i) / $stopwatch->getEvent("subscribe")->getDuration() * 1000, 4);

        echo "subscribe " . $stopwatch->getEvent("subscribe")->getDuration() / 1000 . ' second $i: ' . $i . " op/s {$operationPerSec} memory: " . $stopwatch->getEvent("subscribe")->getMemory() / 1024 / 1024 . "\n\n";
    }

}