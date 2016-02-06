<?php

use Algorithms\Structure\Queue;

class QueueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Queue
     */
    public $queue;

    public function setup()
    {
        $this->queue = new Queue();
    }

    public function generateData()
    {
        $data = md5(microtime());
        return $data;
    }

    public function testOneNodeQueue()
    {
        $data = $this->generateData();
        $this->queue->enqueue($data);
        $lastData = $this->queue->dequeue();
        self::assertTrue($data === $lastData);
    }

    public function testMultiNodeQueue()
    {
        $data = $this->generateData();
        $this->queue->enqueue($data);

        $this->queue->enqueue($this->generateData());
        $this->queue->enqueue($this->generateData());

        $lastData = $this->queue->dequeue();
        self::assertTrue($data === $lastData);

        $allData = $this->queue->listAll();
        self::assertCount(2, $allData);
    }

    public function testDequeueEmptyQueue() {
        self::assertFalse($this->queue->dequeue());
    }
}
