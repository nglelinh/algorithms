<?php

namespace Algorithms\Linear;

/**
 * Interface EquationSolverInterface
 * @package Algorithms\Linear
 */
interface EquationSolverInterface
{

    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation);
}
