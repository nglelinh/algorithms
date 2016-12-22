<?php

namespace Algorithms\Node\LinkedList;

use Algorithms\Base\BaseNode;

/**
 * Class LinkedListNode
 * @package Algorithms\Node\LinkedList
 */
class LinkedListNode extends BaseNode
{
    /**
     * @var LinkedListNode
     */
    protected $next;


    /**
     * LinkedListNode constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

    }//end __construct()


    /**
     * @return LinkedListNode
     */
    public function getNext()
    {
        return $this->next;

    }//end getNext()


    /**
     * @param LinkedListNode $next
     */
    public function setNext($next)
    {
        $this->next = $next;

    }//end setNext()
}//end class
