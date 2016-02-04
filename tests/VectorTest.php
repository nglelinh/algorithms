<?php

use Algorithms\Linear\Vector;

class VectorTest extends PHPUnit_Framework_TestCase
{
    public function testNorm()
    {
        $input  = [1, 2, 2];
        $vector = new Vector($input);
        self::assertEquals(3, $vector->norm());
    }
}
