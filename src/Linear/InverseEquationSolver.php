<?php

namespace Algorithms\Linear;

class InverseEquationSolver extends EquationSolver {
    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation)
    {
        return $this->operator->multiply($this->operator->invert($equation->getCoefficients()), $equation->getConstants());
    }
}