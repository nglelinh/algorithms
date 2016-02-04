<?php

namespace Algorithms\Linear;

class InverseEquationSolver implements EquationSolverInterface {
    /**
     * @var MatrixOperatorInterface
     */
    private $operator;

    /**
     * InverseEquationSolver constructor.
     * @param MatrixOperatorInterface $operator
     */
    public function __construct(MatrixOperatorInterface $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation)
    {
        return $this->operator->multiply($this->operator->invert($equation->getCoefficients()), $equation->getConstants());
    }
}