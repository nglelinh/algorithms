<?php
namespace Algorithms\Node\Tree;

/**
 * Class BinaryTreeNode
 * @package Algorithms\Node\BinaryTree
 */
class BinaryTreeNode extends TreeNode
{
    /**
     * @var BinaryTreeNode
     */
    protected $left;
    /**
     * @var BinaryTreeNode
     */
    protected $right;
    /**
     * @var BinaryTreeNode
     */
    protected $parent;


    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;

    }//end __construct()


    /**
     * @return bool
     */
    public function isLeftChild()
    {
        $parent = $this->parent;
        if (null === $parent) {
            return false;
        }

        return $parent->left === $this;

    }//end isLeftChild()


    /**
     * @return bool
     */
    public function isRightChild()
    {
        $parent = $this->parent;
        if (null === $parent) {
            return false;
        }

        return $parent->right === $this;

    }//end isRightChild()


    /**
     * @return BinaryTreeNode
     */
    public function getLeft()
    {
        return $this->left;

    }//end getLeft()


    /**
     * @param BinaryTreeNode $left
     */
    public function setLeft($left)
    {
        $this->left = $left;

    }//end setLeft()


    /**
     * @return BinaryTreeNode
     */
    public function getRight()
    {
        return $this->right;

    }//end getRight()


    /**
     * @param BinaryTreeNode $right
     */
    public function setRight($right)
    {
        $this->right = $right;

    }//end setRight()


    /**
     * @return BinaryTreeNode
     */
    public function getParent()
    {
        return $this->parent;

    }//end getParent()


    /**
     * @param BinaryTreeNode $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

    }//end setParent()
}//end class
