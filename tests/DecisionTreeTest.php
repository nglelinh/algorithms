<?php

use Algorithms\ML\DecisionTree;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{

    public function testPrognosis()
    {
        $data   = [];
        $data[] = ["base_key" => "base", "age" => "35", "gender" => "male", "grade" => "fail"];
        $data[] = ["base_key" => "base", "age" => "12", "gender" => "female", "grade" => "fail"];
        $data[] = ["base_key" => "base", "age" => "35", "gender" => "female", "grade" => "fail"];
        $data[] = ["base_key" => "false", "age" => "26", "gender" => "male", "grade" => "fail"];
        $data[] = ["base_key" => "base", "age" => "23", "gender" => "female", "grade" => "fail"];
        $data[] = ["base_key" => "false", "age" => "31", "gender" => "male", "grade" => "medium"];
        $data[] = ["base_key" => "base", "age" => "32", "gender" => "male", "grade" => "medium"];
        $data[] = ["base_key" => "base", "age" => "23", "gender" => "male", "grade" => "medium"];
        $data[] = ["base_key" => "false", "age" => "25", "gender" => "male", "grade" => "medium"];
        $data[] = ["base_key" => "false", "age" => "29", "gender" => "female", "grade" => "medium"];
        $data[] = ["base_key" => "base", "age" => "40", "gender" => "female", "grade" => "medium"];
        $data[] = ["base_key" => "base", "age" => "12", "gender" => "female", "grade" => "medium"];
        $data[] = ["base_key" => "base", "age" => "35", "gender" => "female", "grade" => "medium"];
        $data[] = ["base_key" => "false", "age" => "34", "gender" => "male", "grade" => "good"];
        $data[] = ["base_key" => "base", "age" => "23", "gender" => "female", "grade" => "good"];
        $data[] = ["base_key" => "false", "age" => "31", "gender" => "male", "grade" => "good"];
        $data[] = ["base_key" => "false", "age" => "32", "gender" => "male", "grade" => "good"];
        $data[] = ["base_key" => "false", "age" => "23", "gender" => "male", "grade" => "best"];
        $data[] = ["base_key" => "false", "age" => "25", "gender" => "male", "grade" => "best"];
        $data[] = ["base_key" => "false", "age" => "29", "gender" => "female", "grade" => "best"];
        $data[] = ["base_key" => "base", "age" => "40", "gender" => "female", "grade" => "best"];

        $dt = new DecisionTree($data);
        $dt->classify('base_key', 'base', 'false');

        $target = ["age" => "40", "gender" => "male", "grade" => "best"];
        self::assertEquals('false', $dt->prognosis($target));

        $target = ["age" => "40", "gender" => "male", "grade" => "fail"];
        self::assertEquals('base', $dt->prognosis($target));
    }
}
