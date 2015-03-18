<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:54
 */

include_once __DIR__ . "/vendor/autoload.php";

//var_dump(\QueueTests\Helpers\QueueHelper::getQueue(10));
//die;
//$max = 1000000;
//echo "Rabbit \n";
//(new \QueueTests\Tests\ForeverSubscriberQueue())->run(new \QueueTests\Queue\Queue(new \QueueTests\QueueDriver\RabbitMQDriver(),"asdqwe"),$max);
//
//echo "Redis \n";
//(new \QueueTests\Tests\ForeverSubscriberQueue())->run(new \QueueTests\Queue\Queue(new \QueueTests\QueueDriver\RedisDriver(),"asdqwe"),$max);

$max = 10;
(new \QueueTests\Tests\ForeverSubscriberQueue())->run(new \QueueTests\Queue\Queue(new \QueueTests\QueueDriver\KafkaDriver(),"asdqwe"),$max);

// todo: think about channel name
/*
 *
 * Simplest algorithm
 *
 * $maxQueue = 10;
 * $num = memcache::incr("key")
 * $queueName = 'queue_name' . ($num%$maxQueue)
 */
