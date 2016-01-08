<?php

namespace Algorithms;

use Algorithms\Base\Listable;

/**
 * Class Queue
 * @package Algorithms
 */
class Queue implements Listable
{
    /**
     * @var LinkedListNode
     */
    protected $head;
    /**
     * @var LinkedListNode
     */
    protected $tail;

    /**
     *
     */
    public function __construct(){
        $this->head = NULL;
        $this->tail = NULL;
    }

    /**
     * add an item to the “end” (tail) of the queue
     * @param $value
     */
    public function enqueue($value){
        $newNode = new LinkedListNode($value);
        if($this->isEmpty())
        {
            $this->head = $newNode;
            $this->tail = $newNode;
        }else{
            $currentTail = $this->tail;
            $newNode->setNext($currentTail);
            $this->tail = $newNode;
        }
    }

    /**
     * remove an item from the “front” (head) of the queue
     * @return bool
     */
    public function dequeue(){
        if ($this->isEmpty()) {
            return false;
        }

        $current = $this->tail;
        if($current === $this->head){
            $this->tail = NULL;
            $this->head = NULL;
            return $current->getData();
        }

        while($current){
            if($current->getNext() === $this->head){
                $nodeToDelete = $this->head;
                $this->head = $current;
                $current->setNext(NULL);
                return $nodeToDelete->getData();
            }
            $current = $current->getNext();
        }
        return false;
    }

    /**
     * @return array
     */
    public function listAll(){
        $current = $this->tail;
        $listToReturn = [];
        while($current){
            array_push($listToReturn, $current->getData());
            $current = $current->getNext();
        }
        return $listToReturn;
    }

    /**
     * @return bool
     */
    public function isEmpty(){
        return $this->head === NULL;
    }
}
