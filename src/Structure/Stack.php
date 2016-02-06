<?php

namespace Algorithms\Structure;

use Algorithms\Node\LinkedList\LinkedListNode;

/**
 * Class Stack
 * @package Algorithms
 */
class Stack
{
    /**
     * @var LinkedListNode
     */
    private $top;
    /**
     * @var LinkedListNode
     */
    private $bottom;


    /**
     *
     */
    public function __construct()
    {
        $this->top    = null;
        $this->bottom = null;

    }//end __construct()


    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->top === null;

    }//end isEmpty()


    /**
     * @param $value
     * @return bool
     */
    public function push($value)
    {
        $newNode = new LinkedListNode($value);
        if ($this->isEmpty()) {
            $this->top    = $newNode;
            $this->bottom = $newNode;
        } else {
            $oldTop    = $this->top;
            $this->top = $newNode;
            $newNode->setNext($oldTop);
        }

    }//end push()


    /**
     * @return bool
     */
    public function pop()
    {
        if (!$this->isEmpty()) {
            $top       = $this->top;
            $value     = $top->getData();
            $this->top = $top->getNext();
            return $value;
        }

        return false;

    }//end pop()


    /**
     * @return mixed
     */
    public function peek()
    {
        return $this->top->getData();

    }//end peek()
}//end class
