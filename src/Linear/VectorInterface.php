<?php

namespace Algorithms\Linear;

/**
 * Interface VectorInterface
 * @package Algorithms\Linear
 */
interface VectorInterface
{
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
     * @return VectorInterface
     */
    public function scalarMultiply($value);

    /**
     * @param int $position
     * @return float
     */
    public function getElement($position);

    /**
     * @param VectorInterface $vector
     * @return float
     */
    public function dotProduct(VectorInterface $vector);

    /**
     * @param $precision
     * @return VectorInterface
     */
    public function round($precision);
}
