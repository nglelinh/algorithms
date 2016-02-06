<?php

namespace Algorithms\Structure;

use Algorithms\Node\Tree\BinarySearchTreeNode;

/**
 * Class BinarySearchTree
 * @package Algorithms
 */
class BinarySearchTree extends BinaryTree
{


    /**
     * @param BinarySearchTreeNode $node
     * @return bool
     */
    public function predecessor(BinarySearchTreeNode $node)
    {
        if (null === $node->getLeft()) {
            while ($node->getParent()) {
                if ($node->isRightChild()) {
                    return $node->getParent();
                }

                $node = $node->getParent();
            }
        } else {
            $leftTree = new BinarySearchTree();
            $leftTree->setRoot($node->getLeft());

            return $leftTree->max();
        }

        return false;

    }//end predecessor()


    /**
     * @param BinarySearchTreeNode $node
     * @return bool
     */
    public function successor(BinarySearchTreeNode $node)
    {
        if (null === $node->getRight()) {
            while ($node->getParent()) {
                if ($node->isLeftChild()) {
                    return $node->getParent();
                }

                $node = $node->getParent();
            }
        } else {
            $rightTree = new BinarySearchTree();
            $rightTree->setRoot($node->getRight());

            return $rightTree->max();
        }

        return false;

    }//end successor()


    /**
     * @param $value
     * @return bool
     */
    public function insert($value)
    {
        $newNode = new BinarySearchTreeNode($value);

        if ($this->isEmpty()) {
            $this->setRoot($newNode);

            return true;
        }

        $current = $this->getRoot();
        while ($current) {
            if ($value <= $current->getData()) {
                if (null === $current->getLeft()) {
                    $current->setLeft($newNode);
                    $newNode->setParent($current);

                    return true;
                } else {
                    $current = $current->getLeft();
                }
            } elseif ($value > $current->getData()) {
                if (null === $current->getRight()) {
                    $current->setRight($newNode);
                    $newNode->setParent($current);

                    return true;
                } else {
                    $current = $current->getRight();
                }
            }
        }//end while

        return false;

    }//end insert()


    /**
     * Check if is a valid Binary Search Tree
     * @return bool
     */
    public function validate()
    {
        $valid = true;

        $root = $this->root;

        $left = $root->getLeft();
        if ($left) {
            if ($left->getData() > $root->getData()) {
                return false;
            }

            $leftTree = new self($left);
            $valid    = $valid and $leftTree->validate();
        }

        $right = $root->getRight();
        if ($right) {
            if ($right->getData() < $root->getData()) {
                return false;
            }

            $rightTree = new self($right);
            $valid     = $valid and $rightTree->validate();
        }

        return $valid;

    }//end validate()


    /**
     * @param BinarySearchTreeNode $node
     */
    public function delete(BinarySearchTreeNode $node)
    {
        /*
            * @var BinaryTreeNode $node
        */
        $left   = $node->getLeft();
        $right  = $node->getRight();
        $parent = $node->getParent();

        if ($left === null && $right === null) {
            if ($parent and $node->isLeftChild()) {
                $parent->setLeft(null);
            }

            if ($parent and $node->isRightChild()) {
                $parent->setRight(null);
            }

            $node = null;

            return;
        }

        if ($left !== null && $right === null) {
            if ($parent) {
                if ($node->isLeftChild()) {
                    $parent->setLeft($left);
                }

                if ($node->isRightChild()) {
                    $parent->setRight($left);
                }

                $left->setParent($parent);
            }

            $node = null;

            return;
        }

        if ($left === null && $right !== null) {
            if ($parent) {
                if ($node->isLeftChild()) {
                    $parent->setLeft($right);
                }

                if ($node->isRightChild()) {
                    $parent->setRight($right);
                }

                $right->setParent($parent);
            }

            $node = null;

            return;
        }

        $predecessor = $this->predecessor($node);
        $successor   = $this->successor($node);
        if ($predecessor != null && $predecessor != false) {
            $predecessorValue = $predecessor->getData();
            $this->delete($predecessor);
            $node->setData($predecessorValue);
        } elseif ($successor != null && $successor != false) {
            $successorValue = $successor->getData();
            $this->delete($successor);
            $node->setData($successorValue);
        }

    }//end delete()


    /**
     * @param $value
     * @return bool
     */
    public function deleteValue($value)
    {
        $current   = $this->getRoot();
        $parent    = null;
        $direction = null;
        while ($current) {
            if ($value < $current->getData()) {
                if ($current->getLeft() !== null) {
                    $parent    = $current;
                    $direction = 'left';
                    $current   = $current->getLeft();
                } else {
                    return false;
                }
            } elseif ($value > $current->getData()) {
                if ($current->getRight() !== null) {
                    $parent    = $current;
                    $direction = 'right';
                    $current   = $current->getRight();
                } else {
                    return false;
                }
            } else {
                if ($current->getLeft() === null && $current->getRight() === null) {
                    if ($direction === 'right') {
                        $parent->setRight(null);
                    }

                    if ($direction === 'left') {
                        $parent->setLeft(null);
                    }
                } elseif ($current->getLeft() !== null && $current->getRight() === null) {
                    if ($direction === 'right') {
                        $parent->setRight($current->getLeft());
                    }

                    if ($direction === 'left') {
                        $parent->setLeft($current->left());
                    }
                } elseif ($current->getLeft() === null && $current->getRight() !== null) {
                    if ($direction === 'right') {
                        $parent->setRight($current->getRight());
                    }

                    if ($direction === 'left') {
                        $parent->setLeft($current->getRight());
                    }
                } elseif ($current->getLeft() !== null && $current->getRight() !== null) {
                    if ($direction === 'right') {
                        $parent->setRight($current->getRight());
                    }

                    if ($direction === 'left') {
                        $parent->setLeft($current->getLeft());
                    }

                    $predecessor = $this->predecessor($current);
                    $successor   = $this->successor($current);
                    if ($predecessor !== null && $predecessor !== false) {
                        $current = $predecessor;
                    } elseif ($successor !== null && $successor !== false) {
                        $current = $successor;
                    }
                }//end if

                return true;
            }//end if
        }//end while

        return false;

    }//end deleteValue()


    /**
     * @param $value
     * @return bool
     * @throws Node
     */
    public function search($value)
    {
        $current = $this->getRoot();
        while ($current) {
            if ($value === $current->getData()) {
                return $current;
            }

            if ($value < $current->getData()) {
                if (null === $current->getLeft()) {
                    return false;
                }

                $current = $current->getLeft();
            } elseif ($value > $current->getData()) {
                if (null === $current->getRight()) {
                    return false;
                }

                $current = $current->getRight();
            }
        }

        return false;

    }//end search()


    /**
     * @return bool|TreeNode|BinaryTreeNode|null
     */
    public function max()
    {
        $current = $this->getRoot();

        while ($current->getRight()) {
            $current = $current->getRight();
        }

        return $current;

    }//end max()


    /**
     * @return int
     */
    public function calculateHeight()
    {
        $root = $this->getRoot();

        if ($root === null) {
            return 0;
        }

        $leftTree = new self();
        $leftTree->setRoot($root->getLeft());

        $rightTree = new self();
        $rightTree->setRoot($root->getRight());

        return (max($leftTree->calculateHeight(), $rightTree->calculateHeight()) + 1);

    }//end calculateHeight()
}//end class
