<?php

use Algorithms\ML\CART;
use Algorithms\ML\DecisionTree;
use Algorithms\ML\ID3;

class DecisionTreeTest extends PHPUnit_Framework_TestCase
{
    public function cartProvider()
    {
        $input_data = $this->csv_to_array('../data/testing_student_data.csv');

        $return = [];
        foreach ($input_data['samples'] as $row) {
            $return[] = [$row];
        }

        return $return;
    }

    /**
     * @dataProvider cartProvider
     * @param $row
     */
    public function testCart($row)
    {
        $data = $this->csv_to_array('../data/sampling_student_data.csv');
        $data = $data['samples'];

        $dt = new CART($data);
        $dt->classify('graduate', 'true', 'false');
        self::assertEquals($row['graduate'], $dt->predict($row));
    }

    public function id3Provider()
    {
        $input_data = $this->csv_to_array('../data/testing_weather_data.csv');
        $data       = $input_data['samples'];
        $return = [];
        foreach ($data as $k => $row) {
            $return[] = [$row];
        }
        return $return;
    }

    /**
     * @dataProvider id3Provider
     * @param $row
     */
    public function testID3($row)
    {
        $training_data = $this->csv_to_array('../data/sampling_weather_data.csv');
        array_pop($training_data['header']);

        $dec_tree = new ID3();
        $dec_tree->classify($training_data, 'value');
        echo "Decision tree using ID3:\n";
        $dec_tree->display();
        echo "Prediction on new data set\n";

        self::assertEquals(strtoupper($row['value']), $dec_tree->predict($row));
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
