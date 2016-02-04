<?php
use Algorithms\Linear\Equation;
use Algorithms\Linear\InverseEquationSolver;
use Algorithms\Linear\Matrix;
use Algorithms\Linear\MatrixOperator;

/**
 * Class EquationTest
 */
class EquationTest extends PHPUnit_Framework_TestCase {

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
                array(
                    array(1, 0, 0),
                    array(0, 2, 0),
                    array(0, 0, 3)
                )
            ),
            new Matrix(
                array(
                    array(1),
                    array(2),
                    array(3))
            )
        );
    }

    public function testInverseSolver()
    {
        $solver = new InverseEquationSolver(new MatrixOperator());
        self::assertEquals(
            array(
                array(1),
                array(1),
                array(1)
            ),
            $solver->solve($this->equation)->toArray()
            );
    }
}
