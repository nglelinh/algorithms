<?php
namespace Algorithms\Base;

/**
 * Interface Traversable
 * @package Algorithms\Base
 */
interface Traversable
{

    /**
     * @return mixed
     */
    public function postOrder();

    /**
     * @return mixed
     */
    public function inOrder();

    /**
     * @return mixed
     */
    public function preOrder();

    /**
     * @return mixed
     */
    public function breadthFirst();

    /**
     * @param                        $mode
     * @return mixed
     */
    public function depthFirst($mode);
}
