<?php

use Algorithms\ML\DecisionTree;
use Algorithms\ML\ID3;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{

    public function testCartPrognosis()
    {
        $data   = $this->csv_to_array('sampling_student_data.csv');
        $data   = $data['samples'];

        $dt = new DecisionTree($data);
        $dt->classify('graduate', 'true', 'false');

        $target = ["age" => "40", "gender" => "male", "grade" => "best"];
        self::assertEquals('false', $dt->predict($target));

        $target = ["age" => "40", "gender" => "male", "grade" => "fail"];
        self::assertEquals('true', $dt->predict($target));
    }

    public function testID3()
    {
        $training_data = $this->csv_to_array('sampling_weather_data.csv');
        array_pop($training_data['header']);

        $dec_tree = new ID3();
        $dec_tree->classify($training_data);
        echo "Decision tree using ID3:\n";
        $dec_tree->display();
        echo "Prediction on new data set\n";

        $input_data = $this->csv_to_array('testing_weather_data.csv');
        $data = $input_data['samples'];
        foreach ($data as $k => $row) {
            self::assertEquals(strtoupper($row['value']), $dec_tree->predict($row));
        }
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
