<?php

namespace Algorithms\ML;

use Algorithms\Linear\EquationInterface;
use Algorithms\Linear\EquationSolverInterface;
use Algorithms\Linear\MatrixInterface;

/**
 * Class DiophantineSolver : genetic algorithm https://habrahabr.ru/post/128704/
 * @package Algorithms\ML
 */
class DiophantineSolver implements EquationSolverInterface
{
    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation)
    {

    }
}