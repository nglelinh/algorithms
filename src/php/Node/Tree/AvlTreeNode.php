<?php

namespace Algorithms\Node\Tree;

/**
 * Class AvlTreeNode
 */
class AvlTreeNode extends BinarySearchTreeNode
{
    /**
     * @var int
     */
    protected $height;


    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;

    }//end getHeight()


    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;

    }//end setHeight()
}//end class
