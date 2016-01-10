<?php
namespace Algorithms;

use Algorithms\Base\BaseNode;
use Algorithms\Node\LinkedList\DoubleLinkedListNode;

/**
 * Class Sortable
 * @package Algorithms
 */
class Sortable
{
    /**
     * @param $input
     * @return array
     */
    public function bucketSort($input)
    {
        $biggerTen = $smallerTen = [];
        foreach ($input as $value) {
            if ($value > 9) {
                $biggerTen[] = $value;
            } else {
                $smallerTen[] = $value;
            }
        }
        $biggerTen  = $this->heapSort($biggerTen);
        $smallerTen = $this->radixSort($smallerTen);

        return array_merge($smallerTen, $biggerTen);
    }

    public function quick3Sort()
    {
    }

    /**
     * @param DoubleLinkedList $list
     * @return DoubleLinkedList
     */
    public function quickSort(DoubleLinkedList $list)
    {
        $listToReturn = new DoubleLinkedList();

        $smallerList = new DoubleLinkedList();
        $biggerList  = new DoubleLinkedList();

        $current = $list->getBottom();
        if (!$current) {
            return $listToReturn;
        }

        $pivot   = $current->getData();

        $listToReturn->add($pivot);

        while ($current) {
            if ($current->getData() < $pivot) {
                $smallerList->add($current->getData());
            } elseif ($current->getData() > $pivot) {
                $biggerList->add($current->getData());
            }
            $current = $current->getNext();
        }

        $sortedFirst = $this->quickSort($smallerList);

        $sortedSecond = $this->quickSort($biggerList);

        $listToReturn = $this->append($sortedFirst, $listToReturn);
        $listToReturn = $this->append($listToReturn, $sortedSecond);

        return $listToReturn;
    }

    /**
     * @param DoubleLinkedList $list
     * @return array
     */
    private function split(DoubleLinkedList $list)
    {
        if ($list->count() === 1) {
            $arrayToReturn['firstPart']  = $list;
            $arrayToReturn['secondPart'] = null;
        }

        $arrayToReturn = [];

        $count  = $list->count();
        $middle = ceil($count / 2);

        $arrayToReturn['firstPart']  = new DoubleLinkedList();
        $arrayToReturn['secondPart'] = new DoubleLinkedList();

        $current = $list->getBottom();

        $counter = 1;

        while ($current) {
            $value = $current->getData();

            if ($counter <= $middle) {
                $arrayToReturn['firstPart']->add($value);
            } else {
                $arrayToReturn['secondPart']->add($value);
            }

            $counter++;
            $current = $current->getNext();
        }

        return $arrayToReturn;
    }

    /**
     * @param DoubleLinkedList $first
     * @param DoubleLinkedList $second
     * @return DoubleLinkedListNode|DoubleLinkedList
     */
    private function append(DoubleLinkedList $first, DoubleLinkedList $second)
    {
        $listToReturn = new DoubleLinkedList();
        if ($first->isEmpty()) {
            $listToReturn = $second;
        } elseif ($second->isEmpty()) {
            $listToReturn = $first;
        } else {
            /** @var DoubleLinkedListNode $bottom */
            $bottom = $second->getBottom();
            $bottom->setPrev($first->getTop());
            $first->getTop()->setNext($second->getBottom());
            $listToReturn->setBottom($first->getBottom());
            $listToReturn->setTop($second->getTop());
        }

        return $listToReturn;
    }

    /**
     * Merges two sorted linked lists non recursively
     * @param DoubleLinkedList $first
     * @param DoubleLinkedList $second
     * @return DoubleLinkedList
     */
    private function merge(DoubleLinkedList $first, DoubleLinkedList $second)
    {
        $listToReturn = new DoubleLinkedList();

        if ($first === null) {
            $listToReturn = $second;
        } elseif ($second === null) {
            $listToReturn = $first;
        } else {
            while (!$first->isEmpty() && !$second->isEmpty()) {
                if ($first->getBottom()->getData() < $second->getBottom()->getData()) {
                    $listToReturn->push($first->getBottom()->getData());
                    $first->delete();
                } else {
                    $listToReturn->push($second->getBottom()->getData());
                    $second->delete();
                }
            }
            while (!$first->isEmpty()) {
                $listToReturn->push($first->getBottom()->getData());
                $first->delete();
            }
            while (!$second->isEmpty()) {
                $listToReturn->push($second->getBottom()->getData());
                $second->delete();
            }
        }

        return $listToReturn;
    }

    /**
     * Does not change object's loaded datastructure.
     * Is a recursive function.
     * @param DoubleLinkedList $list
     * @return DoubleLinkedList
     */
    public function mergeSort(DoubleLinkedList $list)
    {
        if ($list->count() < 2) {
            return $list;
        }
        $array  = $this->split($list);
        $first  = $this->mergeSort($array['firstPart']);
        $second = $this->mergeSort($array['secondPart']);

        return $this->merge($first, $second);
    }

    /**
     * bubble smallest item down
     * @param DoubleLinkedList $list
     */
    public function bubbleSort(DoubleLinkedList $list)
    {
        $current = $list->getBottom();
        while ($current) {
            $selectedToCompare = $current->getNext();
            while ($selectedToCompare) {
                if ($current->getData() > $selectedToCompare->getData()) {
                    $this->swap($current, $selectedToCompare);
                }
                $selectedToCompare = $selectedToCompare->getNext();
            }
            $current = $current->getNext();
        }
    }

    /**
     * @param BaseNode $a
     * @param BaseNode $b
     */
    private function swap(BaseNode $a, BaseNode $b)
    {
        $temp = $b->getData();
        $b->setData($a->getData());
        $a->setData($temp);
    }

    /**
     * @param DoubleLinkedList $list
     */
    public function selectionSort(DoubleLinkedList $list)
    {
        $current       = $list->getBottom();
        while ($current) {
            $minElement = $current;
            $iterator   = $current->getNext();
            while ($iterator) {
                if ((int)$minElement->getData() > (int)$iterator->getData()) {
                    $minElement = $iterator;
                }
                $iterator = $iterator->getNext();
            }
            if ($current->getData() > $minElement->getData()) {
                $this->swap($current, $minElement);
            }
            $current = $current->getNext();
        }
    }

    /**
     * that's why LinkedList implement ArrayAccess and Countable !!!!
     * @param $data
     */
    public function shellSort($data)
    {
        $gaps = [
            701,
            301,
            132,
            57,
            23,
            10,
            4,
            1
        ];
        $count = count($data);
        foreach ($gaps as $gap) {
            if ($gap < $count) {
                // forward
                for ($i = 0; $i < $count - $gap; $i++) {
                    if ($data[$i] > $data[$i + $gap]) {
                        $tmp             = $data[$i];
                        $data[$i]        = $data[$i + $gap];
                        $data[$i + $gap] = $tmp;
                        // backward $gap step
                        for ($j = $i; $j >= $gap; $j -= $gap) {
                            if ($data[$j] < $data[$j - $gap]) {
                                $tmp             = $data[$j];
                                $data[$j]        = $data[$j - $gap];
                                $data[$j - $gap] = $tmp;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    /**
     * @param DoubleLinkedList $list
     */
    public function insertionSort(DoubleLinkedList $list)
    {
        $current       = $list->getBottom();
        while ($current) {
            $selectedToCompare = $current->getNext();
            while ($selectedToCompare) {
                if ($current->getData() > $selectedToCompare->getData()) {
                    $this->swap($selectedToCompare, $current);
                }
                $selectedToCompare = $selectedToCompare->getNext();
            }
            $current = $current->getNext();
        }
    }

    /**
     * @param array $input
     * @return array
     */
    public function heapSort($input)
    {
        $output = [];
        $input  = $this->buildMaxHeap($input);

        while (count($input) > 0) {
            $max = $input[0];
            array_unshift($output, $max);
            if (1 === count($input)) {
                return $output;
            }
            $input[0] = array_pop($input);
            $input    = $this->siftDown($input, 0);
        }

        return $output;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function buildMaxHeap($input)
    {
        $index = count($input) - 1;

        while ($index >= 0) {
            $input = $this->siftDown($input, $index);
            $index--;
        }

        return $input;
    }

    /**
     * @param $array
     * @param $index
     * @return mixed
     */
    private function siftDown($array, $index)
    {
        $length = count($array);

        while ($index < $length) {
            $leftChildIndex = $this->getHeapLeftChildIndex($index);
            if ($leftChildIndex >= $length) {
                return $array;
            }

            $swapIndex       = $leftChildIndex;
            $rightChildIndex = $leftChildIndex + 1;

            if ($rightChildIndex < $length AND $array[$rightChildIndex] > $array[$leftChildIndex]) {
                $swapIndex = $rightChildIndex;
            }

            if ($array[$index] < $array[$swapIndex]) {
                $temp              = $array[$index];
                $array[$index]     = $array[$swapIndex];
                $array[$swapIndex] = $temp;
            }

            $index = $swapIndex;
        }

        return $array;
    }

    /**
     * @param $index
     * @return int
     */
    private function getHeapLeftChildIndex($index)
    {
        return 2 * $index + 1;
    }

    /**
     * @param $input
     * @return array
     */
    public function countSort($input)
    {
        $result = [];
        $range  = max($input);

        $count = array_fill_keys(range(0, $range), 0);
        foreach ($input as $value) {
            $count[$value]++;
        }

        $total = 0;
        foreach (range(0, $range) as $i) {
            $oldCount  = $count[$i];
            $count[$i] = $total;
            $total += $oldCount;
        }

        foreach ($input as $value) {
            $result[$count[$value]] = $value;
            $count[$value]--;
        }

        return $result;
    }

    /**
     * @param $input
     * @return array
     */
    public function radixSort($input)
    {
        $digit_range = (int)log(max($input), 10) + 1;

        foreach (range(1, $digit_range) as $digit) {
            $buckets = array_fill_keys(range(0, 10), []);
            foreach ($input as $value) {
                $bucket_key             = $value % (pow(10, $digit));
                $buckets[$bucket_key][] = $value;
            }

            $input = [];
            foreach ($buckets as $bucket) {
                $input = array_merge($input, $bucket);
            }
        }

        return $input;
    }
}
