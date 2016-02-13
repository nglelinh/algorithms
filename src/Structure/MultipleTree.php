<?php

namespace Algorithms\Structure;

use Algorithms\Base\BaseTree;
use Algorithms\Node\Tree\MultipleTreeNode;

class MultipleTree extends BaseTree
{
    /**
     * ID3 constructor.
     */
    public function __construct()
    {
        parent::__construct(new MultipleTreeNode());
    }

    public function display()
    {
        $this->root->display(0);
    }
}