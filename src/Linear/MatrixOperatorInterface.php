<?php

namespace Algorithms\Linear;

interface MatrixOperatorInterface
{
    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function add(MatrixInterface $m1, MatrixInterface $m2);

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function subtract(MatrixInterface $m1, MatrixInterface $m2);

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function multiply(MatrixInterface $m1, MatrixInterface $m2);

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function strassenMultiply(MatrixInterface $m1, MatrixInterface $m2);

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     */
    public function transpose(MatrixInterface $matrix);

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     */
    public function invert(MatrixInterface $matrix);

    /**
     *
     * @param MatrixInterface $matrix
     * @param float           $value
     * @return Matrix
     */
    public function scalarMultiply(MatrixInterface $matrix, $value);
}
