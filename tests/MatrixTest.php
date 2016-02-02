<?php

use Algorithms\Linear\Matrix;

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
            $this->m1->add($this->m2)->toArray());
    }

    public function testSubtract()
    {
        self::assertEquals([
            [-1, -1, -1],
            [-1, -1, -1],
            [-1, -1, -1],
        ],
            $this->m1->subtract($this->m2)->toArray());
    }

    public function testDeterminant()
    {
        self::assertEquals(0, $this->m1->determinant());
        self::assertEquals(0, $this->m2->determinant());
        self::assertEquals(6, $this->m3->determinant());
    }

    public function testScalarMultiply()
    {
        self::assertEquals($this->m2->toArray(), $this->m1->scalarMultiply(2)->toArray());
    }

    public function testInvert()
    {
        self::assertEquals([
            [1, 0, 0],
            [0, 1 / 2, 0],
            [0, 0, 1 / 3]
        ],
            $this->m3->invert()->toArray());
    }

    public function testMultiply()
    {
        self::assertEquals([
            [6, 6, 6],
            [6, 6, 6],
            [6, 6, 6]
        ], $this->m1->multiply($this->m2)->toArray());
    }


}
