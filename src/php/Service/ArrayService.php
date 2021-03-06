<?php

namespace Algorithms\Service;

/**
 * Class ArrayService
 * @package Algorithms\Service
 */
/**
 * Class ArrayService
 * @package Algorithms\Service
 */
class ArrayService
{
    /**
     * @param $data
     * @param $key
     * @return array
     * returns a value that is included in the $key variable
     */
    public function get_values_by_key($data, $key)
    {
        $values = [];
        foreach ($data as $value) {
            $values[] = $value[$key];
        }

        return array_values(array_unique($values));
    }

    /**
     * split the $data in the specified category variable
     * @param array $data
     * @param       $key
     * @return array
     */
    public function split_by_key($data, $key)
    {
        if (!$data) {
            return [];
        }

        $split_array = [];
        $values  = self::get_values_by_key($data, $key);

        foreach ($values as $value) {
            $sub_array = [];

            foreach ($data as $item) {
                if ($item[$key] == $value) {
                    $sub_array[] = $item;
                }
            }
            $split_array[$value] = $sub_array;
        }

        return $split_array;
    }

    /**
     * @param $data
     * @return array
     */
    public function list_combine($data)
    {
        $combinations = [];
        $return       = [];

        // extracts a combination
        for ($i = 0; $i < count($data) - 1; $i++) {
            $res = self::calc_combination($data, $i + 1);
            foreach ($res as $value) {
                $combinations[] = $value;
            }
        }

        // Eliminate duplication and long combinations
        $half_length = floor(count($data) / 2);
        $flg         = count($data) % 2;
        $max         = max($data);

        foreach ($combinations as $value) {
            if (count($value) <= $half_length) {
                if ($flg === 0) {
                    if (!array_search($max, $value)) {
                        $return[] = $value;
                    }
                } else {
                    $return[] = $value;
                }
            }
        }

        return $return;
    }

    /**
     * @param $input_array
     * @param $num
     * @return array
     */
    private function calc_combination($input_array, $num)
    {
        $result  = [];
        $arr_num = count($input_array);
        if ($arr_num < $num) {
            return [];
        }

        if ($num === 1) {
            foreach ($input_array as $value) {
                $result[] = [$value];
            }

            return $result;
        }

        if ($num > 1) {
            for ($i = 0; $i < $arr_num - $num + 1; $i++) {
                $ts = self::calc_combination(array_slice($input_array, $i + 1), $num - 1);
                foreach ($ts as $t) {
                    array_unshift($t, $input_array[$i]);
                    $result[] = $t;
                }
            }
        }

        return $result;
    }

    /**
     * @param $data
     * @param $target_attribute
     * @param $value
     * @return mixed
     */
    public function create_subset($data, $target_attribute, $value)
    {
        $header      = $data['header'];
        $samples     = $data['samples'];
        $new_samples = [];

        foreach ($samples as $row) {
            if ($row[$target_attribute] == $value) {
                unset($row[$target_attribute]);
                $new_samples[] = $row;
            }
        }

        unset($header[$target_attribute]);
        $new_data['header']  = $header;
        $new_data['samples'] = $new_samples;

        return ($new_data);
    }

    /**
     * @param $array
     * @param $key
     * @return array
     */
    public function count_values($array, $key)
    {
        $possible_values_count = [];

        foreach ($array as $row) {
            $possible_values_count[$row[$key]] = array_key_exists($row[$key],
                $possible_values_count) ? $possible_values_count[$row[$key]] + 1 : 1;
        }

        return $possible_values_count;
    }
}
