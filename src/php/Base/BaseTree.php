<?php
namespace Algorithms\Base;

/**
 * Class BaseTree
 * @package Algorithms\Base
 */
class BaseTree
{
    /**
     * @var NodeInterface
     */
    protected $root;


    /**
     * BaseTree constructor.
     * @param NodeInterface $root
     */
    public function __construct(NodeInterface $root = null)
    {
        $this->root = $root;

    }//end __construct()


    /**
     * @return NodeInterface
     */
    public function getRoot()
    {
        return $this->root;

    }//end getRoot()


    /**
     * @param NodeInterface $root
     */
    public function setRoot($root)
    {
        $this->root = $root;

    }//end setRoot()
}//end class
