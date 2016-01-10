<?php namespace Algorithms;

use Algorithms\Node\LinkedList\LinkedListNode;

/**
 * Class SingleLinkedList
 * @package Algorithms
 */
class SingleLinkedList extends LinkedList
{

    /**
     * @param $value
     * @return mixed|void
     */
    public function push($value)
    {
        $newNode = new LinkedListNode($value);

        if ($this->isEmpty()) {
            $this->setBottom($newNode);
            $this->setTop($newNode);
        } else {
            $this->top->setNext($newNode);
            $this->setTop($newNode);
        }
        $this->count++;
    }

    /**
     * Deletes from end, and returns value.
     * @return bool
     */
    public function pop()
    {
        $this->rewind();
        $value = null;
        if (!$this->isEmpty()) {
            if ($this->current->getNext() === null) {
                $nodeToDelete = $this->current;
                $value        = $nodeToDelete->getData();
                $this->setTop(null);
                $this->setBottom(null);
                return $value;
            }
            while ($this->current->getNext()->getNext() !== null) {
                $this->next();
            }

            $nodeToDelete = $this->current->getNext();
            $value = $nodeToDelete->getData();
            $this->setTop($this->current);
            $this->current->setNext(null);
            return $value;
        }

        return false;
    }

    /**
     * Add to beginning. Reverse of push();
     * @param $value
     * @return bool
     */
    public function add($value)
    {
        $newNode = new LinkedListNode($value);

        if ($this->isEmpty()) {
            $this->bottom = $newNode;
            $this->top    = $newNode;
            $this->count++;
        } else {
            $currentBottom = $this->bottom;
            $this->bottom->setNext($currentBottom);
            $this->count++;
        }

        return true;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function insertAfter($key, $value)
    {
        $newNode = new LinkedListNode($value);
        $this->rewind();
        $currentKey = 0;
        while ($this->current) {
            if ($currentKey === $key) {
                $next = $this->current->getNext();
                $this->current->setNext($newNode);
                $newNode->setNext($next);

                return true;
            }
            $this->next();
            $currentKey++;
        }

        return false;
    }

    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function insertBefore($key, $value)
    {
        $newNode = new LinkedListNode($value);
        $this->rewind();
        $currentKey = 0;
        while ($this->current && $currentKey !== $key) {
            if ($currentKey + 1 === $key) {
                $nodeToInsertBefore = $this->current->getNext();
                $this->current->setNext($newNode);
                $newNode->setNext($nodeToInsertBefore);

                return true;
            }
            $this->next();
            $currentKey++;
        }

        return false;
    }

    /**
     * @param mixed $offset
     * @return mixed|void
     */
    public function offsetUnset($offset)
    {
        // $counter = 0;
        // $current = $this->bottom;
        // while($current){
        //     $counter++;
        //     $current = $current->next();
        // }
        // if($counter == $offset){
        //     $next = $current->next();
        //
        //     if($this->count()==1){
        //         $this->top = NULL;
        //         $this->bottom = NULL;
        //     }elseif($counter == $this->count()){
        //         $this->top = $prev;
        //     }else{
        //         $prev->next($next);
        //         $next->prev($prev);
        //     }
        //     $current = NULL;
        //     return true;
        // }else{
        //     return false;
        // }
    }

    /**
     * Delete from beginning. Reverse of pop();
     */
    public function delete()
    {
        if (!$this->isEmpty()) {
            $nodeToDelete = $this->bottom;
            $value        = $nodeToDelete->getData();
            $newBottom    = $nodeToDelete->getNext();
            $this->setBottom($newBottom);

            return $value;
        }

        return false;
    }

    /**
     * @param $value
     * @return mixed
     */
    public function search($value)
    {
        // TODO: Implement search() method.
    }
}
