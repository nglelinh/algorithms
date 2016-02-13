<?php

namespace Algorithms\Structure;

use Algorithms\Base\BaseTree;

class MultipleTree extends BaseTree
{
    public function display()
    {
        $this->root->display(0);
    }
}