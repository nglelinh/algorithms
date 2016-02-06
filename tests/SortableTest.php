<?php

use Algorithms\Structure\DoubleLinkedList;
use Algorithms\Structure\Sortable;

/**
 * Class SortableTest
 */
class SortableTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var DoubleLinkedList
     */
    public $doubleLinkedList;

    /**
     * @var
     */
    public $values;
    /**
     * @var Sortable
     */
    public $sortable;

    /**
     * @var
     */
    public $sorted;

    /**
     *
     */
    public function setup()
    {
        $this->doubleLinkedList = new DoubleLinkedList();
        $this->values = [
            8,
            6,
            5,
            9,
            1,
            12,
            2,
            10,
            4,
            11,
            3,
            13
        ];
        
        $this->sorted = [
            1,
            2,
            3,
            4,
            5,
            6,
            8,
            9,
            10,
            11,
            12,
            13
        ];
        foreach ($this->values as $value) {
            $this->doubleLinkedList->push($value);
        }

        $this->sortable = new Sortable();
    }

    /**
     *
     */
    public function testBucketSort()
    {
        $start = microtime();
        $sorted = $this->sortable->bucketSort($this->values);
        self::assertEquals($sorted, $this->sorted);
        $end = microtime();
        echo "\n" . "Bucket Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testBubbleSort()
    {
        $start = microtime();
        $this->sortable->bubbleSort($this->doubleLinkedList);
        self::assertEquals($this->doubleLinkedList->listAll(), $this->sorted);
        $end = microtime();
        echo "\n" . "Bubble Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testSelectionSort()
    {
        $start = microtime();
        $this->sortable->selectionSort($this->doubleLinkedList);
        self::assertEquals($this->doubleLinkedList->listAll(), $this->sorted);
        $end = microtime();
        echo "\n" . "Selection Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testShellSort()
    {
        $start = microtime();
        $result = $this->sortable->shellSort($this->doubleLinkedList->listAll());
        self::assertEquals($result, $this->sorted);
        $end = microtime();
        echo "\n" . "Shell Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testInsertionSort()
    {
        $start = microtime();
        $this->sortable->insertionSort($this->doubleLinkedList);
        self::assertEquals($this->doubleLinkedList->listAll(), $this->sorted);
        $end = microtime();
        echo "\n" . "Insertion Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testMergeSort()
    {
        $start = microtime();
        $sorted = $this->sortable->mergeSort($this->doubleLinkedList);
        self::assertEquals($sorted->listAll(), $this->sorted);
        $end = microtime();
        echo "\n" . "Merge Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testQuickSort()
    {
        $start = microtime();
        $sorted = $this->sortable->quickSort($this->doubleLinkedList);
        self::assertEquals($sorted->listAll(), $this->sorted);
        $end = microtime();
        echo "\n" . "Quick Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testHeapSort()
    {
        $start = microtime();
        $sorted = $this->sortable->heapSort($this->values);
        self::assertEquals($sorted, $this->sorted);
        $end = microtime();
        echo "\n" . "Heap Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testCountSort()
    {
        $start = microtime();
        $sorted = $this->sortable->countSort($this->values);
        self::assertEquals($sorted, $this->sorted);
        $end = microtime();
        echo "\n" . "Count Sort: " . ($end - $start);
    }

    /**
     *
     */
    public function testRadixSort()
    {
        $start = microtime();
        $sorted = $this->sortable->radixSort($this->values);
        self::assertEquals($sorted, $this->sorted);
        $end = microtime();
        echo "\n" . "Radix Sort: " . ($end - $start);
    }
}
