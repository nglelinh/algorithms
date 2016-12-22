<?php

namespace Algorithms\Linear;

/**
 * Interface EquationInterface
 * @package Algorithms\Linear
 */
interface EquationInterface
{
    /**
     * @return bool
     */
    public function validate();

    /**
     * @return bool
     */
    public function solvable();

    /**
     * @return MatrixInterface
     */
    public function getCoefficients();

    /**
     * @return MatrixInterface
     */
    public function getConstants();
}