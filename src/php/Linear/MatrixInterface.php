<?php

namespace Algorithms\Linear;

/**
 * Interface MatrixInterface
 * @package Algorithms\Linear
 */
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
     * @param int $row
     * @param int $column
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

    /**
     * @param int $row
     * @return array
     */
    public function getRow($row);

    /**
     * @param int $row
     * @param array $value
     */
    public function setRow($row, array $value);

    /**
     * @param int $column
     * @return array
     */
    public function getColumn($column);

    /**
     * @param int $column
     * @param array $value
     */
    public function setColumn($column, array $value);

    /**
     * @param int $row1
     * @param int $row2
     */
    public function swapRows($row1, $row2);

    /**
     * @param int $column1
     * @param int $column2
     */
    public function swapColumns($column1, $column2);

    /**
     * @return bool
     */
    public function invertible();

    /**
     * @return Vector
     */
    public function toVector();
}
