<?php

namespace Algorithms\Linear;

class Diophantine implements EquationInterface
{
    private $coefficients = array();

    /**
     * Diophantine constructor.
     * @param array $coefficients
     */
    public function __construct(array $coefficients)
    {
        $this->coefficients = $coefficients;
    }

    /**
     * @return bool
     */
    public function validate()
    {
        // TODO: Implement validate() method.
    }

    /**
     * @return bool
     */
    public function solvable()
    {
        // TODO: Implement solvable() method.
    }

    /**
     * @return MatrixInterface
     */
    public function getCoefficients()
    {
        return array_pop(array_values($this->coefficients));
    }

    /**
     * @return MatrixInterface
     */
    public function getConstants()
    {
        return end(array_values($this->coefficients));
    }
}