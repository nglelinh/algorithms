<?php

namespace Algorithms\Linear;

class InverseEquationSolver implements EquationSolverInterface {

    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation)
    {
        return $equation->getCoefficients()->invert()->multiply($equation->getConstants());
    }
}