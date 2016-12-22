<?php

namespace Algorithms\Base;

/**
 * Class BaseNode
 * @package Algorithms\Base
 */
class BaseNode implements NodeInterface
{
    /**
     * @var
     */
    protected $data;


    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;

    }//end getData()


    /**
     * @param $value
     * @return mixed
     */
    public function setData($value)
    {
        $this->data = $value;
        return $this->data;

    }//end setData()
}//end class
