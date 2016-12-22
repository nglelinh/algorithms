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
     * @param int $row
     * @param int $column
     * @return float
     */
    public function getElement($row, $column)
    {
        return $this->data[$row][$column];
    }

    /**
     * @param int   $row
     * @param int   $column
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
     * @return bool
     */
    public function isIdentity()
    {
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                if (($i === $j AND $this->getElement($i, $j) !== 1)
                    OR ($i !== $j AND $this->getElement($i, $j) !== 0)
                ) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return bool
     */
    public function isDiagonal()
    {
        for ($i = 0; $i < $this->rows(); $i++) {
            for ($j = 0; $j < $this->columns(); $j++) {
                if ($i !== $j AND $this->getElement($i, $j) !== 0) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param int $row
     * @return array
     */
    public function getRow($row)
    {
        return $this->data[$row];
    }

    /**
     * @param int   $row
     * @param array $value
     * @throws InvalidArgumentException
     */
    public function setRow($row, array $value)
    {
        if (count($value) !== $this->columns()) {
            throw new InvalidArgumentException();
        }

        $this->data[$row] = array_values($value);
    }

    /**
     * @param int $column
     * @return array
     */
    public function getColumn($column)
    {
        $return = [];
        for ($row = 0; $row < $this->rows(); $row++) {
            $return[$row] = $this->getElement($row, $column);
        }

        return $return;
    }

    /**
     * @param int   $column
     * @param array $value
     * @throws InvalidArgumentException
     */
    public function setColumn($column, array $value)
    {
        if ($value->rows() !== 1 OR $value->columns() !== $this->columns()) {
            throw new InvalidArgumentException();
        }

        for ($row = 0; $row < $this->rows(); $row++) {
            $return[$row] = $this->setElement($row, $column[$row]);
        }
    }

    /**
     * @param int $row1
     * @param int $row2
     */
    public function swapRows($row1, $row2)
    {
        $temp = $this->getRow($row1);
        $this->setRow($row1, $this->getRow($row2));
        $this->setRow($row2, $temp);
    }

    /**
     * @param int $column1
     * @param int $column2
     */
    public function swapColumns($column1, $column2)
    {
        $temp = $this->getColumn($column1);
        $this->setColumn($column1, $this->getColumn($column2));
        $this->setColumn($column2, $temp);
    }

    /**
     * @return bool
     */
    public function invertible()
    {
        return $this->determinant() !== 0;
    }

    /**
     * @return Vector
     * @throws InvalidArgumentException
     */
    public function toVector()
    {
        if ($this->rows() === 1) {
            return new Vector($this->getRow(0));
        }

        if ($this->columns() === 1) {
            return new Vector($this->getColumn(0));
        }

        throw new InvalidArgumentException();
    }
}