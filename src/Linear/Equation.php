<?php

namespace Algorithms\Linear;

/**
 * Class Equation
 * @package Algorithms\Linear
 */
class Equation implements EquationInterface {

    /**
     * @var MatrixInterface
     */
    private $coefficients;

    /**
     * @var MatrixInterface
     */
    private $constants;

    /**
     * Equation constructor.
     * @param MatrixInterface $coefficients
     * @param MatrixInterface $constants
     */
    public function __construct(MatrixInterface $coefficients, MatrixInterface $constants)
    {
        $this->coefficients = $coefficients;
        $this->constants    = $constants;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        return $this->coefficients->rows() === $this->constants->rows();
    }

    /**
     * @return bool
     */
    public function solvable()
    {
        return $this->coefficients->invertible();
    }

    /**
     * @return MatrixInterface
     */
    public function getCoefficients()
    {
        return $this->coefficients;
    }

    /**
     * @return MatrixInterface
     */
    public function getConstants()
    {
        return $this->constants;
    }
}