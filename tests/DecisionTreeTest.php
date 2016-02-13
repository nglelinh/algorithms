<?php

use Algorithms\ML\DecisionTree;
use Algorithms\ML\ID3;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{

    public function testCartPrognosis()
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

    public function testID3()
    {
        $dec_tree = new ID3();
        $dec_tree->setTrainingData($this->csv_to_array('sampling_travel_data.csv'));
        echo "Decision tree using ID3:\n";
        $dec_tree->display();
        echo "Prediction on new data set\n";
        $dec_tree->predict_outcome($this->csv_to_array('input_travel_data.csv'));
    }

    private function csv_to_array($filename = '', $delimiter = ',')
    {
        $training_data = [];
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header  = [];
        $samples = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $samples[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        foreach ($header as $value) {
            $new_header[$value] = 1;
        }
        $training_data['header']  = $new_header;
        $training_data['samples'] = $samples;

        return $training_data;
    }
}
