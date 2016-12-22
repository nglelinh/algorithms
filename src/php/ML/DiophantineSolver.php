<?php

namespace Algorithms\ML;

use Algorithms\Linear\Diophantine;
use Algorithms\Linear\EquationInterface;
use Algorithms\Linear\EquationSolver;
use Algorithms\Linear\Matrix;
use Algorithms\Linear\MatrixInterface;

/**
 * Class DiophantineSolver : genetic algorithm https://habrahabr.ru/post/128704/
 * @package Algorithms\ML
 */
class DiophantineSolver extends EquationSolver
{
    /**
     *
     */
    const POPULATION_COUNT = 5;
    /**
     * @var Diophantine
     */
    private $equation;

    /**
     * @var array
     */
    private $population;

    /**
     * @var array
     */
    private $population_fitness;

    /**
     * @var int
     */
    private $individualSize = 0;

    /**
     * @var int
     */
    private $constant;

    /**
     * @var MatrixInterface
     */
    private $result;

    /**
     * @param EquationInterface $equation
     * @return MatrixInterface
     */
    public function solve(EquationInterface $equation)
    {
        $this->equation       = $equation;
        $this->individualSize = count($this->equation->getCoefficients()->toArray()[0]);
        $this->constant       = $this->equation->getConstants()->toArray()[0][0];
        $this->population     = $this->initPopulation();

        while (!$this->fitness()) {
            $this->crossover();
            if ($this->fitness()) {
                break;
            }
            $this->mutate();
        }

        $result = new Matrix([1, 2, 3, 4]);

        return $result;
    }

    /**
     * @return bool
     */
    public function fitness()
    {
        $this->population_fitness = [];
        foreach ($this->population as $key => $individual) {
            $this->population_fitness[$key] = $this->constant - $this->operator->multiply($this->equation->getCoefficients(),
                    new Matrix($individual));
            if ($this->population_fitness[$key] === 0) {
                $this->result = $individual;

                return true;
            }
        }

        return false;
    }

    /**
     *
     */
    public function crossover()
    {
        $total_inverse_coefficient  = array_sum($this->population_fitness);
        $population_fitness_percent = array_map(function ($fitness) use ($total_inverse_coefficient) {
            return $fitness / $total_inverse_coefficient * 100;
        }, $this->population_fitness);


    }

    /**
     *
     */
    public function mutate()
    {

    }

    /**
     * @return array
     */
    private function initPopulation()
    {
        $population = [];
        for ($i = 0; $i < self::POPULATION_COUNT; $i++) {
            $individual = [];
            for ($j = 0; $j < $this->individualSize; $j++) {
                $individual[] = mt_rand(0, $this->constant);
            }
            $population[] = $individual;
        }

        return $population;
    }
}