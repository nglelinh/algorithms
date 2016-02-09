<?php

namespace Algorithms\ML;

use Algorithms\Service\ArrayService;

/**
 * Class CART
 * @package Algorithms\ML
 */
class CART
{
    /**
     * @param $data
     * @param $base
     * @param $pred
     * @return float|int|number
     */
    public function calc_delta_I($data, $base, $pred)
    {
        $gini_array = [];

        $split_array = ArrayService::split_by_key($data, $pred);

        foreach ($split_array as $key => $value) {
            $gini_array[$key] = self::calc_gini_index($value, $base);
        }
        $gini_root = self::calc_gini_index($data, $base);

        $delta_I = $gini_root;

        foreach ($split_array as $key => $value) {
            $odd  = self::probability_calculation($data, $pred, $key);
            $gini = $gini_array[$key];
            $delta_I -= $odd * $gini;
        }

        return $delta_I;
    }

    /**
     * measure of inequality
     * @param $data
     * @param $base
     * @return int|number
     */
    public function calc_gini_index($data, $base)
    {
        $odds = [];

        // Extracte the number of individuals each value of the predictor variables
        $feat_array = ArrayService::filter_sub_array_by_key($data, $base);

        // Calculate the probability of occurrence of each value of the predictor variables
        foreach ($feat_array as $value) {
            $odds[] = self::probability_calculation($data, $base, $value);
        }

        $gini = 1;
        foreach ($odds as $odd) {
            $gini -= pow($odd, 2);
        }

        return $gini;
    }

    /**
     * @param $data
     * @param $index
     * @param $value
     * @return float
     *
     * probability of $value in $data[$index]
     */
    private function probability_calculation($data, $index, $value)
    {
        $tmp_sum = 0;

        foreach ($data as $data_value) {
            if ($data_value[$index] == $value) {
                $tmp_sum++;
            }
        }

        return $tmp_sum / count($data);
    }

    /**
     * @param array $data
     * @param       $base
     * @param       $base_value
     * @param       $split_key
     * @param       $split_value
     * @return DecisionTreeNode
     */
    public function make_decision_tree($data, $base, $base_value, $split_key, $split_value)
    {
        $delta_I_array = [];

        $dtdata              = self::makeDtData($data, $base, $base_value);
        $dtdata->split_key   = $split_key;
        $dtdata->split_value = $split_value;

        $dtnode           = new DecisionTreeNode($dtdata);
        $dtnode->terminal = false;

        // calculate the delta_I for each category variable
        $keys = array_keys($data[0]);
        foreach ($keys as $k => $key) {
            if ($key == $base) {
                continue;
            }
            $delta_I_array[$key] = self::calc_delta_I($data, $base, $key);
        }

        $flg = 0;
        foreach ($delta_I_array as $value) {
            if ($value) {
                $flg = 1;
            }
        }
        if ($flg == 0) {
            $dtnode->terminal = true;

            return $dtnode;
        }

        $split_key = array_search(max($delta_I_array), $delta_I_array);

        $split_array = ArrayService::split_by_key($data, $split_key);
        $i           = 0;
        foreach ($split_array as $key => $value) {
            if ($i === 0) {
                $dtnode->setLeft(self::make_decision_tree($value, $base, $base_value, $split_key, $key));
            } else {
                $dtnode->setRight(self::make_decision_tree($value, $base, $base_value, $split_key, $key));
            }

            $i++;
        }

        return $dtnode;
    }

    /**
     * @param $data
     * @param $base
     * @param $value
     * @return DecisionTreeData
     */
    private function makeDtData($data, $base, $value)
    {
        $decisionTreeData         = new DecisionTreeData();
        $decisionTreeData->number = count($data);

        $split_array = ArrayService::split_by_key($data, $base);

        if (isset($split_array[$value])) {
            $decisionTreeData->match = count($split_array[$value]);
        } else {
            $decisionTreeData->match = 0;
        }
        $decisionTreeData->unmatch = $decisionTreeData->number - $decisionTreeData->match;

        return $decisionTreeData;
    }
}
