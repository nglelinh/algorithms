<?php

namespace Algorithms\Service;

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
    public function get_sub_array_by_key($data, $key)
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
        $feat_array  = self::get_sub_array_by_key($data, $key);

        // Calculate the probability of occurrence of each value of the predictor variables
        foreach ($feat_array as $value) {
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
        $return = [];

        // extracts a combination
        for ($i = 0; $i < count($data) - 1; $i++) {
            $res = self::calc_combination($data, $i + 1);
            foreach ($res as $value) {
                $combinations[] = $value;
            }
        }

        // Eliminate duplication and long combinations
        $half_length = floor(count($data) / 2);
        $flg    = count($data) % 2;
        $max = max($data);

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
}