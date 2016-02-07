<?php

namespace Algorithms\Linear;

/**
 * Class Vector
 * @package Algorithms\Linear
 */
class Vector implements VectorInterface
{

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
        $return = [];

        foreach ($this->data as $value) {
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
        $result = [];
        foreach ($this->data as $element) {
            $result[] = $element * $value;
        }

        return new Vector($result);
    }

    /**
     * @param int $position
     * @return float
     */
    public function getElement($position)
    {
        return $this->data[$position];
    }

    /**
     * @param VectorInterface $vector
     * @return float
     */
    public function dotProduct(VectorInterface $vector)
    {
        $result = 0;
        for ($i = 0; $i < count($this->data); $i++) {
            $result += $this->getElement($i) * $vector->getElement($i);
        }

        return $result;
    }

    /**
     * @param $precision
     * @return VectorInterface
     */
    public function round($precision)
    {
        foreach ($this->data as &$value) {
            $value = round($value, $precision);
        }

        return $this;
    }
}
