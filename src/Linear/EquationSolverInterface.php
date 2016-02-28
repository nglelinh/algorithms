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

    /**
     * @param EquationInterface $equation
     * @param MatrixInterface   $check
     * @return bool
     */
    public function isRoot(EquationInterface $equation, MatrixInterface $check);
}
