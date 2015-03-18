<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 19:04
 */

namespace QueueTests\Helpers;


class QueueHelper
{

    public static function getQueue($maxNumber)
    {
        $memcache = new \Memcache;
        $memcache->connect('localhost', 11211);
        $memcache->add("my_incr",0);
        $number = $memcache->increment("my_incr");
        return "my_queue_". ($number%$maxNumber);
    }
}