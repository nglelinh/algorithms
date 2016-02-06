<?php

namespace Algorithms\Structure;

use Algorithms\Node\Tree\AvlTreeNode;

/**
 * Class AvlTree
 * @package Algorithms
 */
class AvlTree extends BinarySearchTree
{


    /**
     * @param $value
     * @return bool
     */
    public function insert($value)
    {
        return parent::insert($value);

    }//end insert()


    /**
     * @return int
     */
    public function calculateHeight()
    {
        /*
            * @var AvlTreeNode $root
        */
        $root = $this->root;

        if ($root === null) {
            return 0;
        }

        $leftTree = new self();
        $leftTree->root($root->left());

        $rightTree = new self();
        $rightTree->root($root->right());

        $root->setHeight(max($leftTree->calculateHeight(), $rightTree->calculateHeight()) + 1);
        return $root->getHeight();

    }//end calculateHeight()


    /**
     *
     */
    public function leftRotate()
    {
        $this->calculateHeight();
        $oldRoot = $this->root();
        $right   = $oldRoot->right();

        if ($right === null) {
            return;
        }

        $this->root($right);
        $middleElement = $this->root()->left();
        $this->root()->left($oldRoot);

        $oldRoot->right($middleElement);

    }//end leftRotate()
}//end class
