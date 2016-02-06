<?php

namespace Algorithms\Linear;

class MatrixOperator implements MatrixOperatorInterface
{
    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function add(MatrixInterface $m1, MatrixInterface $m2)
    {
        if ($m1->columns() !== $m2->columns() OR $m1->rows() !== $m2->rows()) {
            throw new InvalidArgumentLinearException();
        }

        $result = [];
        for ($i = 0; $i < $m1->rows(); $i++) {
            for ($j = 0; $j < $m1->columns(); $j++) {
                $result[$i][$j] = $m1->getElement($i, $j) + $m2->getElement($i, $j);
            }
        }

        return new Matrix($result);
    }

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function subtract(MatrixInterface $m1, MatrixInterface $m2)
    {
        if ($m1->columns() !== $m2->columns() OR $m1->rows() !== $m2->rows()) {
            throw new InvalidArgumentLinearException();
        }

        $result = [];
        for ($i = 0; $i < $m1->rows(); $i++) {
            for ($j = 0; $j < $m1->columns(); $j++) {
                $result[$i][$j] = $m1->getElement($i, $j) - $m2->getElement($i, $j);
            }
        }

        return new Matrix($result);
    }

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function multiply(MatrixInterface $m1, MatrixInterface $m2)
    {
        if ($m1->columns() !== $m2->rows()) {
            throw new InvalidArgumentLinearException();
        }

        $result = [];
        for ($a = 0; $a < $m1->rows(); $a++) {
            for ($b = 0; $b < $m2->columns(); $b++) {
                $result[$a][$b] = 0;
                for ($i = 0; $i < $m1->columns(); $i++) {
                    $result[$a][$b] += $m1->getElement($a, $i) * $m2->getElement($i, $b);
                }
            }
        }

        return new Matrix($result);
    }

    /**
     * should really use LU decomp. instead of Cramer's here. much faster.
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     * @throws InvalidArgumentLinearException
     */
    public function invert(MatrixInterface $matrix)
    {
        $return = [];
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $cofactor       = $matrix->getCofactorMatrix($i, $j);
                $return[$i][$j] = pow(-1, $i + $j) * $cofactor->determinant();
            }
        }

        $return = new Matrix($return);
        $det    = $matrix->determinant();
        if ($det == 0) {
            throw new InvalidArgumentLinearException();
        }

        $return = $this->scalarMultiply($return, 1 / $det);
        $this->transpose($matrix);

        return $return;
    }

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     */
    public function transpose(MatrixInterface $matrix)
    {
        $return = [];
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $return[$j][$i] = $matrix->getElement($i, $j);
            }
        }

        return new Matrix($return);
    }

    /**
     *
     * @param MatrixInterface $matrix
     * @param float           $value
     * @return Matrix
     */
    public function scalarMultiply(MatrixInterface $matrix, $value)
    {
        $return = [];
        for ($i = 0; $i < $matrix->rows(); $i++) {
            for ($j = 0; $j < $matrix->columns(); $j++) {
                $return[$i][$j] = $matrix->getElement($i, $j) * $value;
            }
        }

        return new Matrix($return);
    }

    /**
     * @param MatrixInterface $m1
     * @param MatrixInterface $m2
     * @return MatrixInterface
     */
    public function strassenMultiply(MatrixInterface $m1, MatrixInterface $m2)
    {
    }

    /**
     * @param MatrixInterface $matrix
     * @return MatrixInterface
     * array($C, $P)
     * C = L + U - E
     * $P - permutation
     */
    public function lupDecomposition(MatrixInterface $matrix)
    {
        $size = $matrix->rows();
        $C = clone $matrix;
        $P = array(); // permutation
        for ($i = 0; $i < $size; $i++) {
            $P[$i] = $i;
        }
        for ($i = 0; $i < $size; $i++) {
            //поиск опорного элемента
            $pivotValue = 0; // max element on column $i
            $pivot = -1;
            for ($row = $i; $row < $size; $row++) {
                if (abs($C->getElement($row, $i)) > $pivotValue) {
                    $pivotValue = abs($C->getElement($row, $i));
                    $pivot = $row;
                }
            }
            //меняем местами i-ю строку и строку с опорным элементом
            if ($pivot !== $i) {
                list($P[$i], $P[$pivot]) = array($P[$pivot], $P[$i]);
                $C->swapRows($pivot, $i);
            }
            for ($j = $i + 1; $j < $size; $j++) { // row
                $temp = $C->getElement($j, $i) / $C->getElement($i, $i);
                for($k = $i; $k < $size; $k++) { // column
                    $C->setElement($j, $k, $C->getElement($j, $k) - $temp * $C->getElement($i, $k));
                }
            }
        }
        return $C;
    }

    /**
     * https://en.wikipedia.org/wiki/Power_iteration
     * @param MatrixInterface $matrix
     * @return Vector
     */
    public function getEigenVector(MatrixInterface $matrix)
    {
        $iterations = 20000;
        $dim        = $matrix->rows();
        for ($i = 0; $i < $dim; $i++) {
            $value[] = 1;
        }

        $b = new Vector($value);

        for ($i = 0; $i < $iterations; $i++) {
            $b      = $this->multiply($matrix, $b->toColumnMatrix())->toVector();
            $b      = $b->scalarMultiply(1/$b->norm());
        }

        return $b;
    }
}
