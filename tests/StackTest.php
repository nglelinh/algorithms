<?php

use Algorithms\Structure\Stack;

class StackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Stack
     */
    public $stack;

    public function setup()
    {
        $this->stack = new Stack();
    }

    public function generateData()
    {
        $data = md5(microtime());
        return $data;
    }

    public function testAddData()
    {
        $data = $this->generateData();
        $this->stack->push($data);
        $lastData = $this->stack->pop();
        self::assertTrue($data === $lastData);
    }

    public function testAddAnotherData()
    {
        $data = $this->generateData();
        $this->stack->push($data);
        $anotherData = $this->generateData();
        $this->stack->push($anotherData);
        $lastAnotherData = $this->stack->pop();
        self::assertTrue($anotherData === $lastAnotherData);
    }

    public function testPopEmptyStack()
    {
        self::assertFalse($this->stack->pop());
    }

    public function testPeek()
    {
        $data = $this->generateData();
        $this->stack->push($data);
        self::assertEquals($data, $this->stack->peek());
    }
}
