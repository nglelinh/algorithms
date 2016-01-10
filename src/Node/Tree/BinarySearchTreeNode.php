<?php

namespace Algorithms\Node\Tree;

/**
 * Class BinarySearchTreeNode
 * @package Algorithms\Node\BinaryTree
 */
class BinarySearchTreeNode extends BinaryTreeNode
{


    /**
     * @return bool
     */
    public function valid()
    {
        if ($this->data !== null) {
            $left = $this->getLeft();
            if ($left !== null && $left > $this->getData()) {
                return false;
            }

            $right = $this->getRight();
            if ($right !== null && $right < $this->getData()) {
                return false;
            }
        }

        return true;

    }//end valid()
}//end class
