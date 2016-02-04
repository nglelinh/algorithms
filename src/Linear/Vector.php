<?php

namespace Algorithms\Linear;

/**
 * Class Vector
 * @package Algorithms\Linear
 */
class Vector implements VectorInterface {

    /**
     * @var array
     */
    private $data;

    /**
     * Vector constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return float
     */
    public function norm()
    {
        $return = 0;

        foreach ($this->data as $value) {
            $return += $value * $value;
        }

        return sqrt($return);
    }

    /**
     * @return MatrixInterface
     */
    public function toRowMatrix()
    {
        return new Matrix($this->data);
    }

    /**
     * @return MatrixInterface
     */
    public function toColumnMatrix()
    {
        $return = array();

        foreach ($this->data as $value)
        {
            $return[] = [$value];
        }

        return new Matrix($return);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param $value
     * @return Vector
     */
    public function scalarMultiply($value)
    {
        $result = array();
        foreach ($this->data as $element)
        {
            $result[] = $element * $value;
        }
        return new Vector($result);
    }
}
