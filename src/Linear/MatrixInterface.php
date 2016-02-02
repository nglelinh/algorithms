<?php

namespace Algorithms\Linear;

/**
 * Interface MatrixInterface
 * @package Algorithms\Linear
 */
interface MatrixInterface
{
    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     */
    public function add(MatrixInterface $matrix);

    /**
     * @param MatrixInterface $second
     * @return MatrixInterface
     */
    public function subtract(MatrixInterface $second);

    /**
     * @param MatrixInterface $second
     * @return MatrixInterface
     */
    public function multiply(MatrixInterface $second);

    /**
     * @param MatrixInterface $second
     * @return MatrixInterface
     */
    public function strassenMultiply(MatrixInterface $second);

    /**
     * @return float
     */
    public function determinant();

    /**
     * @return MatrixInterface
     */
    public function invert();

    /**
     * @return MatrixInterface
     */
    public function transpose();

    /**
     * @param $row
     * @param $column
     * @return float
     */
    public function getElement($row, $column);

    /**
     * @param int $row
     * @param int $column
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
     *
     * @param float $value
     * @return Matrix
     */
    public function scalarMultiply($value);
}
