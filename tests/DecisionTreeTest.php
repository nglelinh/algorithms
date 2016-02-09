<?php

use Algorithms\ML\DecisionTree;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{

    public function testPrognosis()
    {
        $data     = [];
        $data[0]  = ["base_key" => "base", "age" => "35", "gender" => "male", "grade" => "1等"];
        $data[1]  = ["base_key" => "base", "age" => "12", "gender" => "female", "grade" => "1等"];
        $data[2]  = ["base_key" => "base", "age" => "35", "gender" => "female", "grade" => "1等"];
        $data[3]  = ["base_key" => "false_value", "age" => "26", "gender" => "male", "grade" => "1等"];
        $data[4]  = ["base_key" => "base", "age" => "23", "gender" => "female", "grade" => "1等"];
        $data[5]  = ["base_key" => "false_value", "age" => "31", "gender" => "male", "grade" => "2等"];
        $data[6]  = ["base_key" => "base", "age" => "32", "gender" => "male", "grade" => "2等"];
        $data[7]  = ["base_key" => "base", "age" => "23", "gender" => "male", "grade" => "2等"];
        $data[8]  = ["base_key" => "false_value", "age" => "25", "gender" => "male", "grade" => "2等"];
        $data[9]  = ["base_key" => "false_value", "age" => "29", "gender" => "female", "grade" => "2等"];
        $data[10] = ["base_key" => "base", "age" => "40", "gender" => "female", "grade" => "2等"];
        $data[11] = ["base_key" => "base", "age" => "12", "gender" => "female", "grade" => "2等"];
        $data[12] = ["base_key" => "base", "age" => "35", "gender" => "female", "grade" => "2等"];
        $data[13] = ["base_key" => "false_value", "age" => "34", "gender" => "male", "grade" => "3等"];
        $data[14] = ["base_key" => "base", "age" => "23", "gender" => "female", "grade" => "3等"];
        $data[15] = ["base_key" => "false_value", "age" => "31", "gender" => "male", "grade" => "3等"];
        $data[16] = ["base_key" => "false_value", "age" => "32", "gender" => "male", "grade" => "3等"];
        $data[17] = ["base_key" => "false_value", "age" => "23", "gender" => "male", "grade" => "乗組員"];
        $data[18] = ["base_key" => "false_value", "age" => "25", "gender" => "male", "grade" => "乗組員"];
        $data[19] = ["base_key" => "false_value", "age" => "29", "gender" => "female", "grade" => "乗組員"];
        $data[20] = ["base_key" => "base", "age" => "40", "gender" => "female", "grade" => "乗組員"];

        $dt = new DecisionTree($data);
        $dt->classify('base_key', 'base', 'false_value');

        $target = ["age" => "40", "gender" => "male", "grade" => "2等"];
        self::assertEquals('false_value', $dt->prognosis($target));
    }
}
