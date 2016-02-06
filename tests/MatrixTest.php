<?php

use Algorithms\Linear\Matrix;
use Algorithms\Linear\MatrixOperator;

/**
 * Class MatrixTest
 */
class MatrixTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Matrix
     */
    private $m1;

    /**
     * @var Matrix
     */
    private $m2;

    /**
     * @var Matrix
     */
    private $m3;

    /**
     * @var MatrixOperator
     */
    private $operator;

    public function setUp()
    {
        parent::setUp();
        $this->m1 = new Matrix([
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
        ]);
        $this->m2 = new Matrix([
            [2, 2, 2],
            [2, 2, 2],
            [2, 2, 2],
        ]);
        $this->m3 = new Matrix([
                [1, 0, 0],
                [0, 2, 0],
                [0, 0, 3]
            ]
        );

        $this->operator = new MatrixOperator();
    }

    public function testToArray()
    {
        self::assertEquals([
            [1, 1, 1],
            [1, 1, 1],
            [1, 1, 1],
        ],
            $this->m1->toArray());
    }

    public function testAdd()
    {
        self::assertEquals([
            [3, 3, 3],
            [3, 3, 3],
            [3, 3, 3],
        ],
            $this->operator->add($this->m1, $this->m2)->toArray());
    }

    public function testSubtract()
    {
        self::assertEquals([
            [-1, -1, -1],
            [-1, -1, -1],
            [-1, -1, -1],
        ],
            $this->operator->subtract($this->m1, $this->m2)->toArray());
    }

    public function testDeterminant()
    {
        self::assertEquals(0, $this->m1->determinant());
        self::assertEquals(0, $this->m2->determinant());
        self::assertEquals(6, $this->m3->determinant());
    }

    public function testScalarMultiply()
    {
        self::assertEquals($this->m2->toArray(), $this->operator->scalarMultiply($this->m1, 2)->toArray());
    }

    public function testInvert()
    {
        self::assertEquals([
            [1, 0, 0],
            [0, 1 / 2, 0],
            [0, 0, 1 / 3]
        ],
            $this->operator->invert($this->m3)->toArray());
    }

    public function testMultiply()
    {
        self::assertEquals([
            [6, 6, 6],
            [6, 6, 6],
            [6, 6, 6]
        ], $this->operator->multiply($this->m1, $this->m2)->toArray());
    }

    public function testIdentity()
    {
        $matrix = new Matrix([
            [1, 0, 0],
            [0, 1, 0],
            [0, 0, 1],
        ]);

        self::assertTrue($matrix->isIdentity());

        $matrix = new Matrix([
            [3, 0, 0],
            [0, 1, 0],
            [0, 0, 1],
        ]);
        self::assertFalse($matrix->isIdentity());
    }

    public function testDiagonal()
    {
        $matrix = new Matrix([
            [1, 0, 0],
            [0, 3, 0],
            [0, 0, 1],
        ]);

        self::assertTrue($matrix->isDiagonal());

        $matrix = new Matrix([
            [3, 0, 0],
            [1, 1, 0],
            [0, 0, 1],
        ]);
        self::assertFalse($matrix->isDiagonal());
    }

    public function testTranspose()
    {
        $input  = [
            [1, 0, 0],
            [0, 3, 0],
            [0, 0, 1],
        ];
        $matrix = new Matrix($input);

        self::assertEquals($input, $this->operator->transpose($matrix)->toArray());

        $input  = [
            [1, 0, 0],
            [0, 3, 0],
            [5, 0, 1],
        ];
        $matrix = new Matrix($input);

        $output = [
            [1, 0, 5],
            [0, 3, 0],
            [0, 0, 1],
        ];
        self::assertEquals($output, $this->operator->transpose($matrix)->toArray());
    }

    public function testLupDecomposition()
    {
        $input  = [
            [1, 0, 1],
            [0, 3, 0],
            [2, 0, 1],
        ];
        $matrix = new Matrix($input);

        $output = [
            [2, 0, 1],
            [0, 3, 0],
            [0, 0, 0.5],
        ];
        self::assertEquals($output, $this->operator->lupDecomposition($matrix)->toArray());
    }

    public function testEigenVector()
    {

        $input  = [
            [1, 0, 1],
            [0, 3, 0],
            [5, 0, 1],
        ];
        $matrix = new Matrix($input);

        self::assertEquals([
            0.40514439225657484,
            0.12307775598439666,
            0.90593039876410797
        ], $this->operator->getEigenVector($matrix)->toArray());
    }
}
