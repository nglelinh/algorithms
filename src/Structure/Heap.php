<?php

namespace Algorithms\Structure;

use Algorithms\Base\NodeInterface;
use Algorithms\Node\Tree\BinaryTreeNode;

/**
 * Class Heap
 * @package Algorithms
 */
class Heap extends BinaryTree
{
    /**
     *
     */
    const TYPE_MAX = 'max';
    /**
     *
     */
    const TYPE_MIN = 'min';

    /**
     * @var
     */
    protected $type;

    /**
     * Heap constructor.
     * @param NodeInterface $root
     */
    public function __construct(NodeInterface $root)
    {
        parent::__construct($root);
        $this->type = self::TYPE_MAX;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        /** @var BinaryTreeNode $root */
        $root  = $this->root;
        $valid = true;
        $left  = $root->getLeft();
        if ($left) {
            if ($this->isMaxHeap() AND ($left->getData() > $root->getData())) {
                return false;
            }

            if (!$this->isMaxHeap() AND ($left->getData() < $root->getData())) {
                return false;
            }

            $leftTree = new self($left);
            $valid = $leftTree->validate();
        }

        $right = $root->getRight();
        if ($right) {
            if ($this->isMaxHeap() AND ($right->getData() > $root->getData())) {
                return false;
            }

            if (!$this->isMaxHeap() AND ($right->getData() < $root->getData())) {
                return false;
            }

            $rightTree = new self($right);
            $valid = $rightTree->validate();
        }

        return $valid;
    }

    /**
     * @param $value
     */
    public function insert($value)
    {
        $nodeToAttach = $this->findFirstAvaliableNode();
        $nodeToAdd    = new BinaryTreeNode($value);

        if ($nodeToAttach->left === null) {
            $nodeToAttach->left($nodeToAdd);
        } elseif ($nodeToAttach->right === null) {
            $nodeToAttach->right($nodeToAdd);
        }

        // Heapify
        if ($nodeToAttach->get() < $nodeToAdd->getData()) {
            // parent node?
        }
    }

    /**
     *
     * Similar to bredth first traversal
     *
     * @return Ambigous <NULL, DataStructureNode>
     */
    public function findFirstAvaliableNode()
    {
        $queue = new Queue();

        $queue->enqueue($this->root);
        while (!$queue->isEmpty()) {
            $dequeue = $queue->dequeue();
            if ($dequeue->left !== null) {
                $queue->enqueue($dequeue->left);
            } else {
                return dequeue;
            }
            if ($dequeue->right != null) {
                $queue->enqueue($dequeue->right);
            } else {
                return dequeue;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return bool
     */
    public function isMaxHeap()
    {
        return $this->type === self::TYPE_MAX;
    }
}
