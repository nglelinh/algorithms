<?php

namespace Algorithms\Node\Tree;

use Algorithms\Base\BaseNode;

class MultipleTreeNode extends BaseNode
{
    /**
     * @var array
     */
    public $children;

    /**
     * Node constructor.
     * @param $data
     */
    public function __construct($data = null)
    {
        $this->data     = $data;
        $this->children = [];
    }

    /**
     * @param $level
     */
    public function display($level)
    {
        echo $this->getData() . "\n";
        /**
         * @var  Node $child_node
         */
        foreach ($this->children as $name => $child_node) {
            echo str_repeat(" ", ($level + 1) * 4) . str_repeat("-",
                    14 / 2 - strlen($name) / 2) . $name . str_repeat("-",
                    14 / 2 - strlen($name) / 2) . ">";
            $child_node->display($level + 1);
        }
    }
}