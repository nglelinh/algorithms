<?php namespace Algorithms;

use Algorithms\Node\LinkedList\DoubleLinkedListNode;

/**
 * Class DoubleLinkedList
 * @package Algorithms
 */
class DoubleLinkedList extends LinkedList
{


    /**
     * @param $value
     */
    public function push($value)
    {
        $newNode = new DoubleLinkedListNode($value);

        if ($this->isEmpty()) {
            $this->setBottom($newNode);
            $this->setTop($newNode);
        } else {
            $oldTop = $this->top;
            $oldTop->setNext($newNode);
            $newNode->setPrev($oldTop);
            $this->setTop($newNode);
        }

        $this->count++;

    }//end push()


    /**
     * Deletes from end, and returns value.
     * @return bool
     */
    public function pop()
    {
        if (!$this->isEmpty()) {
            $this->rewind();
            /*
                * @var DoubleLinkedListNode $nodeToDelete
            */
            $nodeToDelete = $this->top;
            $value        = $nodeToDelete->getData();
            if ($nodeToDelete->getPrev()) {
                $this->top = $nodeToDelete->getPrev();
            }

            if ($this->top) {
                $this->top->setNext(null);
            }

            return $value;
        }

        return false;

    }//end pop()


    /**
     * Add to beginning. Reverse of push();
     * @param $value
     * @return bool
     */
    public function add($value)
    {
        $newNode = new DoubleLinkedListNode($value);

        if ($this->isEmpty()) {
            $this->bottom = $newNode;
            $this->top    = $newNode;
            $this->count++;

            return true;
        } else {
            /*
                * @var DoubleLinkedListNode $currentBottom
            */
            $currentBottom = $this->bottom;
            $currentBottom->setPrev($newNode);
            $this->bottom = &$newNode;
            $this->bottom->setNext($currentBottom);
            $this->count++;

            return true;
        }

    }//end add()


    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function insertAfter($key, $value)
    {
        $newNode = new DoubleLinkedListNode($value);
        $this->rewind();
        $currentKey = 0;
        while ($this->current) {
            if ($currentKey === $key) {
                /*
                    * @var DoubleLinkedListNode $next
                */
                $next = $this->current->getNext();
                $next->setPrev($newNode);
                $this->current->setNext($newNode);
                $newNode->setNext($next);

                return true;
            }

            $this->next();
            $currentKey++;
        }

        return false;

    }//end insertAfter()


    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function insertBefore($key, $value)
    {
        $newNode = new DoubleLinkedListNode($value);
        $this->rewind();
        $currentKey = 0;
        while ($this->current) {
            if ($currentKey === $key) {
                /*
                    * @var DoubleLinkedListNode $current
                */
                $current = $this->current;
                $prev    = $current->getPrev();
                $prev->setNext($newNode);
                $current->setPrev($newNode);
                $newNode->setPrev($prev);

                return true;
            }

            $this->next();
            $currentKey++;
        }

        return false;

    }//end insertBefore()


    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetUnset($offset)
    {
        $counter = 0;
        /*
            * @var DoubleLinkedListNode $current
        */
        $current = $this->bottom;
        while ($current) {
            if ($counter === $offset) {
                /*
                    * @var DoubleLinkedListNode $next
                */
                $next = $current->getNext();
                $prev = $current->getPrev();

                if ($this->count() === 1) {
                    $this->top    = null;
                    $this->bottom = null;
                } elseif ($counter === $this->count()) {
                    $this->top = $prev;
                } else {
                    $prev->setNext($next);
                    $next->setPrev($prev);
                }

                $current = null;

                return true;
            }//end if

            $counter++;
            $current = $current->getNext();
        }//end while

        throw new \OutOfBoundsException();

    }//end offsetUnset()


    /**
     * Delete from beginning. Reverse of pop();
     */
    public function delete()
    {
        if (!$this->isEmpty()) {
            $nodeToDelete = $this->bottom;
            $value        = $nodeToDelete->getData();
            $newBottom    = $nodeToDelete->getNext();
            if ($newBottom !== null) {
                /*
                    * @var DoubleLinkedListNode $newBottom
                */
                $newBottom->setPrev(null);
            }

            $this->bottom = $newBottom;

            return $value;
        }

        return false;

    }//end delete()
}//end class
