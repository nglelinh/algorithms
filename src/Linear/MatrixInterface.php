<?php

namespace Algorithms\Linear;

/**
 * Interface MatrixInterface
 * @package Algorithms\Linear
 */
interface MatrixInterface
{
    /**
     * @return float
     */
    public function determinant();

    /**
     * @param $row
     * @param $column
     * @return float
     */
    public function getElement($row, $column);

    /**
     * @param int   $row
     * @param int   $column
     * @param float $value
     */
    public function setElement($row, $column, $value);

    /**
     * @return int
     */
    public function columns();

    /**
     * @return int
     */
    public function rows();

    /**
     * @return array
     */
    public function toArray();

    /**
     * @return bool
     */
    public function isSquare();

    /**
     * @return bool
     */
    public function isIdentity();

    /**
     * @return bool
     */
    public function isDiagonal();
}
