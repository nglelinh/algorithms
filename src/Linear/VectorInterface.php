<?php

namespace Algorithms\Linear;

/**
 * Interface VectorInterface
 * @package Algorithms\Linear
 */
interface VectorInterface {
    /**
     * @return float
     */
    public function norm();

    /**
     * @return MatrixInterface
     */
    public function toRowMatrix();

    /**
     * @return MatrixInterface
     */
    public function toColumnMatrix();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param $value
     * @return Vector
     */
    public function scalarMultiply($value);
}
