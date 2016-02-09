<?php

namespace Algorithms\ML;

use Algorithms\Node\Tree\BinarySearchTreeNode;

/**
 * Class DecisionTreeNode
 * @package Algorithms\ML
 */
class DecisionTreeNode extends BinarySearchTreeNode {
    /**
     * @var DecisionTreeData
     */
    public $data;

    /**
     * @var bool
     */
    public $terminal;
}
