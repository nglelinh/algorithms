<?php
use Algorithms\Linear\Equation;
use Algorithms\Linear\InverseEquationSolver;
use Algorithms\Linear\Matrix;
use Algorithms\Linear\MatrixOperator;

/**
 * Class EquationTest
 */
class EquationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var EquationInterface
     */
    private $equation;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->equation = new Equation(
            new Matrix(
                [
                    [1, 0, 0],
                    [0, 2, 0],
                    [0, 0, 3]
                ]
            ),
            new Matrix(
                [
                    [1],
                    [2],
                    [3]
                ]
            )
        );
    }

    public function testInverseSolver()
    {
        $solver = new InverseEquationSolver(new MatrixOperator());
        self::assertEquals(
            [
                [1],
                [1],
                [1]
            ],
            $solver->solve($this->equation)->toArray()
        );
    }

    public function testIsRoot()
    {
        $solver = new InverseEquationSolver(new MatrixOperator());
        self::assertTrue(
            $solver->isRoot($this->equation, new Matrix([
                [1],
                [1],
                [1]
            ]))
        );
    }

    public function testNotIsRoot()
    {
        $solver = new InverseEquationSolver(new MatrixOperator());
        self::assertFalse(
            $solver->isRoot($this->equation, new Matrix([
                [1],
                [2],
                [1]
            ]))
        );
    }
}
