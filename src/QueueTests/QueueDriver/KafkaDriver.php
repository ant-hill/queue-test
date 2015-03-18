<?php
/**
 * Created by IntelliJ IDEA.
 * User: unit
 * Date: 18.03.15
 * Time: 16:51
 */

namespace QueueTests\QueueDriver;


use Kafka\Protocol\Decoder;
use Kafka\Protocol\Encoder;
use Kafka\Socket;

class KafkaDriver implements DriverInterface
{
    /**
     * @var Socket
     */
    private $socket;
    /**
     * @var Decoder
     */
    private $decoder;
    /**
     * @var Encoder
     */
    private $encoder;


    public function __construct()
    {
        $this->socket = new Socket('localhost', '9092');
        $this->encoder = new Encoder($this->socket);
        $this->decoder = new Decoder($this->socket);
    }

    public function subscribe($channel = "default")
    {
        $this->encoder->fetchRequest($this->receiveMessage($channel));
        return $this->decoder->fetchResponse();
    }

    /**
     * @param $channel
     * @param $message
     * @return mixed
     */
    public function publish($channel, $message)
    {
        $this->encoder->produceRequest($this->publishMessage($channel, $message));
        return $this->decoder->produceResponse();
    }

    private function publishMessage($channel, $message)
    {
        if (!is_array($message)) {
            $message = array($message);
        }
        return array(
            'required_ack' => 1,
            'timeout' => 1000,
            'data' => array(
                array(
                    'topic_name' => $channel,
                    'partitions' => array(
                        array(
                            'partition_id' => 0,
                            'messages' => $message,
                        ),
                    ),
                ),
            ),
        );
    }

    private function receiveMessage($channel)
    {
        return array(
            'data' => array(
                array(
                    'topic_name' => $channel,
                    'partitions' => array(
                        array(
                            'partition_id' => 0,
                            'offset' => 0,
                        ),
                    ),
                ),
            ),
        );
    }
}