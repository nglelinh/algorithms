<?php

namespace Algorithms\Linear;

abstract class EquationSolver implements EquationSolverInterface
{
    /**
     * @var MatrixOperatorInterface
     */
    protected $operator;

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
     * @param MatrixInterface   $check
     * @return bool
     */
    public function isRoot(EquationInterface $equation, MatrixInterface $check)
    {
        return $this->operator->multiply($equation->getCoefficients(), $check)->toArray() === $equation->getConstants()->toArray();
    }
}