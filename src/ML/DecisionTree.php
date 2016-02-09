<?php

namespace Algorithms\ML;

use Algorithms\Linear\InvalidArgumentException;
use Algorithms\Service\ArrayService;
use Algorithms\Structure\BinaryTree;

/**
 * Class DecisionTree
 * @package Algorithms\ML
 */
class DecisionTree extends BinaryTree implements DecisionTreeInterface
{
    /**
     * @var
     */
    private $binary_variable_data;
    /**
     * @var array
     */
    private $data;
    /**
     * @var
     */
    private $base_key;
    /**
     * @var
     */
    private $base_value;
    /**
     * @var
     */
    private $false_value;

    /**
     * DecisionTree constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @param $base_key
     * @param $base_value
     * @param $false_value
     * @return DecisionTreeNode
     */
    public function classify($base_key, $base_value, $false_value)
    {
        $this->base_key    = $base_key;
        $this->base_value  = $base_value;
        $this->false_value = $false_value;

        $this->binary_variable_data = $this->make_binary_variable_data($this->data, $base_key);

        $tree = CART::make_decision_tree($this->binary_variable_data,
            $this->base_key,
            $this->base_value,
            $this->base_key,
            $this->base_value);

        $this->root = $tree;

        return $tree;
    }

    /**
     * @param $target
     * @return mixed
     */
    public function prognosis($target)
    {
        $result = $this->exe_prognosis($this->root, $target);

        return $result;
    }

    /**
     * @param DecisionTreeNode $node
     * @param                  $target
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function exe_prognosis(DecisionTreeNode $node, $target)
    {
        // returns the value of the objective variable at leaf
        if ($node->terminal) {
            // Check the number of each type of objective variable value
            $true_num  = $node->getData()->match;
            $false_num = $node->getData()->unmatch;

            if ($true_num > $false_num) {
                $pars = $true_num / ($true_num + $false_num);
                echo $pars . "\n";

                return $this->base_value;
            }

            $pars = $false_num / ($true_num + $false_num);
            echo $pars . "\n";

            return $this->false_value;
        }

        $split_key   = $node->getLeft()->getData()->split_key;
        $left_value  = $node->getLeft()->getData()->split_value;
        $right_value = $node->getRight()->getData()->split_value;

        // To determine whether a continuous variable
        $feat_array = ArrayService::filter_sub_array_by_key($this->data, $split_key);
        if (count($feat_array) > 3 && is_numeric($feat_array[0])) {
            if (!(strstr('<=x', $left_value) == false)) {
                $flg    = 1;
                $border = trim($left_value, '<=x');
            } else {
                $flg    = 2;
                $border = trim($right_value, '<=x');
            }
        } else {
            $flg = 0;
        }

        switch ($flg) {
            case 0:
                if (!(strstr($left_value, $target[$split_key]) == false)) {
                    return $this->exe_prognosis($node->getLeft(), $target);
                } else {
                    if (!(strstr($right_value, $target[$split_key]) == false)) {
                        return $this->exe_prognosis($node->getRight(), $target);
                    }
                }
                break;
            case 1:
                if ($border >= $target[$split_key]) {
                    return $this->exe_prognosis($node->getRight(), $target);
                } else {
                    return $this->exe_prognosis($node->getLeft(), $target);
                }
                break;
            case 2:
                if ($border >= $target[$split_key]) {
                    return $this->exe_prognosis($node->getLeft(), $target);
                } else {
                    return $this->exe_prognosis($node->getRight(), $target);
                }
                break;
            default:
                throw new InvalidArgumentException();
        }
    }

    /**
     * @param $data
     * @param $base_key
     * @return array
     */
    private function make_binary_variable_data($data, $base_key)
    {
        $multiple_param   = [];
        $continuous_param = [];

        // 各変数の種類を確認 (3種類以上ある変数はどれか)
        $keys = array_keys($data[0]);
        foreach ($keys as $k => $key) {
            // 目的変数は対象外 
            if ($key == $base_key) {
                continue;
            }

            // 「連続変数」と「多値変数」の判断
            $feat_array = ArrayService::filter_sub_array_by_key($data, $key);
            if (count($feat_array) >= 3) {
                if (is_numeric($feat_array[0])) {
                    array_push($continuous_param, $key);
                } else {
                    array_push($multiple_param, $key);
                }
            }
        }

        // 2値変数へ圧縮
        foreach ($multiple_param as $key => $pred) {
            // 指定した多値変数を2値変数に圧縮する
            $data = $this->multiple_to_binary($data, $base_key, $pred);
        }
        foreach ($continuous_param as $key => $pred) {
            // 指定した連続変数を2値変数に圧縮する
            $data = $this->continuous_to_binary($data, $base_key, $pred);
        }

        return $data;
    }

    /**
     * @param $data
     * @param $base_key
     * @param $pred
     * @return array
     */
    private function continuous_to_binary($data, $base_key, $pred)
    {
        $feat_array = ArrayService::filter_sub_array_by_key($data, $pred);

        asort($feat_array);
        $combs = [];

        for ($i = 1; $i < count($feat_array); $i++) {
            $combs[$i]         = array_slice($feat_array, 0, $i);
            $tmp_data          = $this->to_binary_data($data, $pred, $combs[$i], 'type1', 'type2');
            $delta_I_array[$i] = CART::calc_delta_I($tmp_data, $base_key, $pred);
        }

        $maxdikeys = array_keys($delta_I_array, max($delta_I_array));
        $maxdikey  = $maxdikeys[0];

        $group_max = max($combs[$maxdikey]);

        $type1_name = $group_max . " <=x";
        $type2_name = $group_max . " >x";

        foreach ($data as $num => $array) {
            $chk = $array[$pred];
            if (in_array($chk, $combs[$maxdikey])) {
                $tmp_array        = $array;
                $tmp_array[$pred] = $type1_name;
                $tmp_data[$num]   = $tmp_array;
            } else {
                $tmp_array        = $array;
                $tmp_array[$pred] = $type2_name;
                $tmp_data[$num]   = $tmp_array;
            }
        }

        return $tmp_data;
    }

    /**
     * @param $data
     * @param $base
     * @param $pred
     * @return array
     */
    private function multiple_to_binary($data, $base, $pred)
    {
        $feat_array = ArrayService::filter_sub_array_by_key($data, $pred);

        $combs = ArrayService::list_comb($feat_array);

        foreach ($combs as $comb_key => $comb) {
            $tmp_data                 = $this->to_binary_data($data, $pred, $comb, 'type1', 'type2');
            $delta_I_array[$comb_key] = CART::calc_delta_I($tmp_data, $base, $pred);
        }

        $max_key = array_search(max($delta_I_array), $delta_I_array);

        $type1_name = "";
        $type2_name = "";
        foreach ($feat_array as $key => $value) {
            if (in_array($value, $combs[$max_key])) {
                $type1_name .= $value;
            } else {
                $type2_name .= $value;
            }
        }

        $tmp_data = $this->to_binary_data($data, $pred, $combs[$max_key], $type1_name, $type2_name);

        return $tmp_data;
    }

    /**
     * @param array $data
     * @param       $pred
     * @param       $comb
     * @param       $name1
     * @param       $name2
     * @return array
     */
    private function to_binary_data($data, $pred, $comb, $name1, $name2)
    {
        $tmp_data = [];

        foreach ($data as $num => $array) {
            $chk = $array[$pred];
            if (in_array($chk, $comb)) {
                $tmp_array        = $array;
                $tmp_array[$pred] = $name1;
                $tmp_data[$num]   = $tmp_array;
            } else {
                $tmp_array        = $array;
                $tmp_array[$pred] = $name2;
                $tmp_data[$num]   = $tmp_array;
            }
        }

        return $tmp_data;
    }
}
