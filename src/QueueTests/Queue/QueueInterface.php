<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 17.03.15
 * Time: 9:33
 */

namespace QueueTests\Queue;


interface QueueInterface {

    /**
     * @param mixed $message
     */
    public function publish($message);

    /**
     * @return mixed
     */
    public function subscribe();

}