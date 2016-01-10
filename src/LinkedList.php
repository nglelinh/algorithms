<?php
namespace Algorithms;

use Algorithms\Base\Listable;
use Algorithms\Base\Searchable;
use Algorithms\Node\LinkedList\LinkedListNode;

/**
 * Class LinkedList
 * @package Algorithms
 */
abstract class LinkedList implements Listable, Searchable
{

    /**
     * @var LinkedListNode
     */
    protected $top;

    /**
     * @var LinkedListNode
     */
    protected $bottom;

    /**
     * @var LinkedListNode
     */
    protected $current;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var int
     */
    protected $key;


    /**
     * LinkedList constructor.
     */
    public function __construct()
    {
        $this->current = $this->bottom;
        $this->key     = 0;
        $this->count   = $this->count();

    }//end __construct()


    /**
     * interface DataStructure
     * @return bool
     */
    public function isEmpty()
    {
        return $this->bottom === null;

    }//end isEmpty()


    /**
     * @return array
     */
    public function listAll()
    {
        $listArray = [];
        if (! $this->isEmpty()) {
            $node = $this->getBottom();
            while ($node) {
                array_push($listArray, $node->getData());
                $node = $node->getNext();
            }
        }

        return $listArray;

    }//end listAll()


    /**
     * @return mixed
     */
    public function current()
    {
        return $this->current->getData();

    }//end current()


    /**
     *
     */
    public function next()
    {
        $this->key++;
        $this->current = $this->current->getNext();

    }//end next()


    /**
     * @return int
     */
    public function key()
    {
        return $this->key;

    }//end key()


    /**
     *
     */
    public function rewind()
    {
        $this->key     = 0;
        $this->current = $this->bottom;

    }//end rewind()


    /**
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists($this->key);

    }//end valid()


    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        $counter = 0;
        $current = $this->bottom;
        while ($current) {
            if ($counter === $offset) {
                return true;
            }

            $counter++;
            $current = $current->getNext();
        }

        return false;

    }//end offsetExists()


    /**
     * @param $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        $counter = 0;
        $current = $this->bottom;
        while ($current) {
            if ($counter === $offset) {
                return $current->getData();
            }

            $counter++;
            $current = $current->getNext();
        }

        throw new \OutOfBoundsException();

    }//end offsetGet()


    /**
     * @param $offset
     * @param $value
     * @return bool
     */
    public function offsetSet($offset, $value)
    {
        $counter = 0;
        $current = $this->bottom;
        while ($current) {
            if ($counter === $offset) {
                $current->setData($value);
                return true;
            }

            $counter++;
            $current = $current->getNext();
        }

        throw new \OutOfBoundsException();

    }//end offsetSet()


    /**
     * @param $offset
     * @return mixed
     */
    abstract public function offsetUnset($offset);


    /**
     * @return int
     */
    public function count()
    {
        if ($this->count === null) {
            $this->rewind();
            $count = 0;
            while ($this->current) {
                $count ++;
                $this->current = $this->current->getNext();
            }

            $this->count = $count;
        }

        return $this->count;

    }//end count()


    /**
     * @param $value
     * @return mixed
     */
    abstract public function push($value);


    /**
     * @return LinkedListNode
     */
    public function getTop()
    {
        return $this->top;

    }//end getTop()


    /**
     * @param LinkedListNode $top
     */
    public function setTop($top)
    {
        $this->top = $top;

    }//end setTop()


    /**
     * @return LinkedListNode
     */
    public function getBottom()
    {
        return $this->bottom;

    }//end getBottom()


    /**
     * @param LinkedListNode $bottom
     */
    public function setBottom($bottom)
    {
        $this->bottom = $bottom;

    }//end setBottom()


    public function search($value)
    {
        // TODO: Implement search() method.
    }//end search()
}//end class
