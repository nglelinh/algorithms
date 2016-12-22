<?php

namespace Algorithms\Node\LinkedList;

/**
 * Class DoubleLinkedListNode
 * @package Algorithms\Node\LinkedList
 */
class DoubleLinkedListNode extends LinkedListNode
{
    /**
     * @var LinkedListNode
     */
    protected $prev;


    /**
     * @return LinkedListNode
     */
    public function getPrev()
    {
        return $this->prev;

    }//end getPrev()


    /**
     * @param LinkedListNode $prev
     */
    public function setPrev($prev)
    {
        $this->prev = $prev;

    }//end setPrev()
}//end class
