<?php

namespace Algorithms\Structure;

use Algorithms\Base\BaseTree;
use Algorithms\Base\Searchable;
use Algorithms\Base\Traversable;
use Algorithms\Node\Tree\BinaryTreeNode;
use Algorithms\Structure\Queue;

/**
 * Class BinaryTree
 * @package Algorithms
 */
class BinaryTree extends BaseTree implements Traversable, Searchable
{
    /**
     *
     */
    const SEARCH_POST_ORDER = 'post-order';
    /**
     *
     */
    const SEARCH_PRE_ORDER = 'pre-order';
    /**
     *
     */
    const SEARCH_IN_ORDER = 'in-order';

    /**
     * @return bool
     */
    public function isEmpty()
    {
        if ($this->root === null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function breadthFirst()
    {
        $queue = new Queue();

        $queue->enqueue($this->root);

        $listToReturn = [];

        while (!$queue->isEmpty()) {
            /**
 * @var BinaryTreeNode $dequeue
*/
            $dequeue = $queue->dequeue();
            if ($dequeue->getLeft() !== null) {
                $queue->enqueue($dequeue->getLeft());
            }
            if ($dequeue->getRight() !== null) {
                $queue->enqueue($dequeue->getRight());
            }
            array_push($listToReturn, $dequeue->getData());
        }

        return $listToReturn;
    }

    /**
     * @param                        $mode
     * @return array
     */
    public function depthFirst($mode)
    {
        /**
 * @var BinaryTreeNode $root
*/
        $root = $this->getRoot();
        // uses a Stack
        $resultArray = [];
        $stack       = new Stack();
        switch ($mode) {
            case self::SEARCH_PRE_ORDER:
                /*current + left + right */
                $current = $root;
                $stack->push($current);
                array_push($resultArray, $current->getData());

                while (!$stack->isEmpty()) {
                    if ($current->getLeft() !== null and !in_array($current->getLeft()->getData(), $resultArray)) {
                        $current = $current->getLeft();
                        $stack->push($current);
                        array_push($resultArray, $current->getData());
                    } elseif ($current->getRight() !== null and !in_array(
                        $current->getRight()->getData(),
                        $resultArray
                    )
                    ) {
                        $current = $current->getRight();
                        $stack->push($current);
                        array_push($resultArray, $current->getData());
                    } else {
                        $stack->pop();
                        $current = $current->getParent();
                    }
                }
                break;
            case self::SEARCH_IN_ORDER:
                /*left + current + right */
                $current = $root;
                $stack->push($current);

                while (!$stack->isEmpty()) {
                    if ($current->getLeft() !== null and !in_array($current->getLeft()->getData(), $resultArray)) {
                        $current = $current->getLeft();
                        $stack->push($current);
                    } elseif ($current->getRight() !== null and !in_array(
                        $current->getRight()->getData(),
                        $resultArray
                    )
                    ) {
                        array_push($resultArray, $current->getData());
                        $current = $current->getRight();
                        $stack->push($current);
                    } else {
                        if (!in_array($current->getData(), $resultArray)) {
                            array_push($resultArray, $current->getData());
                        }
                        $stack->pop();
                        $current = $current->getParent();
                    }
                }
                break;
            case self::SEARCH_POST_ORDER:
                /*left + right + current */
                $current = $root;
                $stack->push($current);

                while (!$stack->isEmpty()) {
                    if ($current->getLeft() !== null and !in_array($current->getLeft()->getData(), $resultArray)) {
                        $current = $current->getLeft();
                        $stack->push($current);
                    } elseif ($current->getRight() !== null and !in_array(
                        $current->getRight()->getData(),
                        $resultArray
                    )
                    ) {
                        $current = $current->getRight();
                        $stack->push($current);
                    } else {
                        if (!in_array($current->getData(), $resultArray)) {
                            array_push($resultArray, $current->getData());
                        }
                        $stack->pop();
                        $current = $current->getParent();
                    }
                }
                break;
        }

        return $resultArray;
    }

    /**
     * @return array
     */
    public function inOrder()
    {
        /**
 * @var BinaryTreeNode $root
*/
        $root      = $this->getRoot();
        $listArray = [];
        if (!$this->isEmpty()) {
            $left = $root->getLeft();
            if ($left) {
                $leftTree  = new self($left);
                $listArray = array_merge($listArray, $leftTree->inOrder());
            }
            array_push($listArray, $root->getData());

            $right = $root->getRight();
            if ($right) {
                $rightTree = new self($root->getRight());
                $listArray = array_merge($listArray, $rightTree->inOrder());
            }
        }

        /*left + current + right */

        return $listArray;
    }

    /**
     * @return array
     */
    public function postOrder()
    {
        /**
 * @var BinaryTreeNode $root
*/
        $root      = $this->getRoot();
        $listArray = [];
        if (!$this->isEmpty()) {
            $left = $root->getLeft();
            if ($left) {
                $leftTree  = new self($left);
                $listArray = array_merge($listArray, $leftTree->postOrder());
            }

            $right = $root->getRight();
            if ($right) {
                $rightTree = new self($right);
                $listArray = array_merge($listArray, $rightTree->postOrder());
            }
            array_push($listArray, $root->getData());
        }

        return $listArray;
    }

    /**
     * @return array
     */
    public function preOrder()
    {
        /*current + left + right */
        /**
 * @var BinaryTreeNode $root
*/
        $root      = $this->getRoot();
        $listArray = [];
        array_push($listArray, $root->getData());
        if (!$this->isEmpty()) {
            $left = $root->getLeft();
            if ($left) {
                $leftTree  = new self($left);
                $listArray = array_merge($listArray, $leftTree->preOrder());
            }

            $right = $root->getRight();
            if ($right) {
                $rightTree = new self($right);
                $listArray = array_merge($listArray, $rightTree->preOrder());
            }
        }

        return $listArray;
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
