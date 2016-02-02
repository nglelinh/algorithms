<?php

namespace Algorithms\Linear;

/**
 * Class Matrix
 * @package Algorithms\Linear
 */
class Matrix implements MatrixInterface
{

    /**
     * @var array
     */
    private $data;

    /**
     * Matrix constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function add(MatrixInterface $matrix)
    {
        if ($this->columns() !== $matrix->columns() OR $this->rows() !== $this->rows()) {
            throw new InvalidArgumentLinearException();
        }

        $result = [];
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                $result[$i][$j] = $this->getElement($i, $j) + $matrix->getElement($i, $j);
            }
        }

        return new Matrix($result);
    }

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function subtract(MatrixInterface $matrix)
    {
        if ($this->columns() !== $matrix->columns() OR $this->rows() !== $this->rows()) {
            throw new InvalidArgumentLinearException();
        }

        $result = [];
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                $result[$i][$j] = $this->getElement($i, $j) - $matrix->getElement($i, $j);
            }
        }

        return new Matrix($result);
    }

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function multiply(MatrixInterface $matrix)
    {
        if ($this->columns() !== $matrix->rows()){
            throw new InvalidArgumentLinearException();
        }

        $result = array();
        for ($a = 0; $a < $this->rows(); $a++) {   // our rows
            for ($b = 0; $b < $matrix->columns(); $b++) { // their columns
                $result[$a][$b] = 0;
                for ($i = 0; $i < $this->columns(); $i++) {   // our columns
                    $result[$a][$b] += $this->getElement($a, $i) * $matrix->getElement($i, $b);
                }
            }
        }

        return new Matrix($result);
    }



    /**
     * @return float
     * @throws InvalidArgumentLinearException
     */
    public function determinant()
    {
        if (!$this->isSquare()) {
            throw new InvalidArgumentLinearException();
        }

        if ($this->columns() === 0) {
            return 0;
        }

        if ($this->columns() === 1) {
            return $this->getElement(0, 0);
        }

        $return = 0;
        for ($i = 0; $i < $this->columns(); $i++) {
            $cofactor   = $this->getCofactorMatrix(0, $i);
            $multipland = (pow((-1), $i) * $this->getElement(0, $i));
            $return += $cofactor->determinant() * $multipland;
        }

        return $return;
    }

    /**
     * @param int $cofactorRow
     * @param int $cofactorColumn
     * @return Matrix
     */
    public function getCofactorMatrix($cofactorRow, $cofactorColumn)
    {
        $return = [];
        for ($i = 0, $a = 0; $i < $this->rows(); $i++) {
            $b = 0;
            if ($i != $cofactorRow) {
                for ($j = 0; $j < $this->columns(); $j++) {
                    if ($j != $cofactorColumn) {
                        $return[$a][$b++] = $this->getElement($i, $j);
                    }
                }
                $a++;
            }
        }

        return new Matrix($return);
    }

    /**
     * should really use LU decomp. instead of Cramer's here. much faster.
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function invert()
    {
        $return = [];
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                $cofactor       = $this->getCofactorMatrix($i, $j);
                $return[$i][$j] = pow(-1, $i + $j) * $cofactor->determinant();
            }
        }

        $return = new Matrix($return);
        $det    = $this->determinant();
        if ($det == 0) {
            throw new InvalidArgumentLinearException();
        }

        $return = $return->scalarMultiply(1 / $det);
        $return->transpose();

        return $return;
    }

    /**
     * @return MatrixInterface
     */
    public function transpose()
    {
        $return = [];
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                $return[$j][$i] = $this->getElement($i, $j);
            }
        }

        return new Matrix($return);
    }

    /**
     * @param $row
     * @param $column
     * @return float
     */
    public function getElement($row, $column)
    {
        return $this->data[$row][$column];
    }

    /**
     * @param int $row
     * @param int $column
     * @param float $value
     */
    public function setElement($row, $column, $value)
    {
        $this->data[$row][$column] = $value;
    }

    /**
     * @return int
     */
    public function columns()
    {
        if (isset($this->data[0])) {
            return count($this->data[0]);
        }

        return 0;
    }

    /**
     * @return int
     */
    public function rows()
    {
        return count($this->data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isSquare()
    {
        return $this->rows() === $this->columns();
    }

    /**
     *
     * @param float $value
     * @return Matrix
     */
    public function scalarMultiply($value)
    {
        $return = [];
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                $return[$i][$j] = $this->getElement($i, $j) * $value;
            }
        }

        return new Matrix($return);
    }

    /**
     * @param MatrixInterface $second
     * @return MatrixInterface
     */
    public function strassenMultiply(MatrixInterface $second)
    {

    }
}