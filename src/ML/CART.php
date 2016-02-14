<?php

namespace Algorithms\ML;

use Algorithms\Service\ArrayService;
use Algorithms\Base\BaseTree;
use Algorithms\Linear\InvalidArgumentException;

/**
 * Class CART
 * @package Algorithms\ML
 */
class CART extends BaseTree implements DecisionTreeInterface
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

        $tree = $this->make_decision_tree($this->binary_variable_data,
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
    public function predict($target)
    {
        $result = $this->predict_node($this->root, $target);

        return $result;
    }

    /**
     * @param DecisionTreeNode $node
     * @param                  $target
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function predict_node(DecisionTreeNode $node, $target)
    {
        // returns the value of the objective variable at leaf
        if ($node->terminal) {
            // Check the number of each type of objective variable value
            $true_num  = $node->getData()->match;
            $false_num = $node->getData()->unmatch;

            return $true_num > $false_num ? $this->base_value : $this->false_value;
        }

        $split_key   = $node->getLeft()->getData()->split_key;
        $left_value  = $node->getLeft()->getData()->split_value;
        $right_value = $node->getRight()->getData()->split_value;

        // To determine whether a continuous variable
        $values = ArrayService::get_sub_array_by_key($this->data, $split_key);
        if (count($values) > 3 && is_numeric($values[0])) {
            if (strstr('<=x', $left_value) !== false) {
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
                if (strstr($left_value, $target[$split_key]) !== false) {
                    return $this->predict_node($node->getLeft(), $target);
                } else {
                    return $this->predict_node($node->getRight(), $target);
                }
                break;
            case 1:
                return $this->predict_node($border >= $target[$split_key] ? $node->getRight() : $node->getLeft(),
                    $target);
                break;
            case 2:
                return $this->predict_node($border > $target[$split_key] ? $node->getLeft() : $node->getRight(),
                    $target);
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

        // Check the type of each variable
        $keys = array_keys($data[0]);
        foreach ($keys as $key) {
            // objective var is excluded
            if ($key === $base_key) {
                continue;
            }

            // Determined "continuous variables" of the "multi-variable"
            $values = ArrayService::get_sub_array_by_key($data, $key);
            if (count($values) >= 3) {
                if (is_numeric($values[0])) {
                    $continuous_param[] = $key;
                } else {
                    $multiple_param[] = $key;
                }
            }
        }

        foreach ($multiple_param as $param_name) {
            $data = $this->multiple_to_binary($data, $base_key, $param_name);
        }
        foreach ($continuous_param as $key => $param_name) {
            $data = $this->continuous_to_binary($data, $base_key, $param_name);
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
        $values = ArrayService::get_sub_array_by_key($data, $pred);

        asort($values);
        $combinations = [];

        for ($i = 1; $i <= count($values); $i++) {
            $combinations[$i]  = array_slice($values, 0, $i);
            $result          = $this->to_binary_data($data, $pred, $combinations[$i], 'type1', 'type2');
            $delta_I_array[$i] = $this->calc_delta_I($result, $base_key, $pred);
        }

        $max_keys = array_keys($delta_I_array, max($delta_I_array));
        $max_key  = $max_keys[0];

        $group_max = max($combinations[$max_key]);

        $type1_name = $group_max . "<=x";
        $type2_name = $group_max . ">x";

        $result = [];
        foreach ($data as $num => $array) {
            $chk = $array[$pred];

            $tmp_array = $array;
            if (in_array($chk, $combinations[$max_key])) {
                $tmp_array[$pred] = $type1_name;
            } else {
                $tmp_array[$pred] = $type2_name;
            }
            $result[$num] = $tmp_array;
        }

        return $result;
    }

    /**
     * @param $data
     * @param $base
     * @param $param_name
     * @return array
     */
    private function multiple_to_binary($data, $base, $param_name)
    {
        $values = ArrayService::get_sub_array_by_key($data, $param_name);

        $combinations  = ArrayService::list_combine($values);
        $delta_I_array = [];

        foreach ($combinations as $combination) {
            $binary_data     = $this->to_binary_data($data, $param_name, $combination, 'type1', 'type2');
            $delta_I_array[] = $this->calc_delta_I($binary_data, $base, $param_name);
        }

        $max_key = array_search(max($delta_I_array), $delta_I_array);

        $type1_name = "";
        $type2_name = "";
        foreach ($values as $key => $value) {
            if (in_array($value, $combinations[$max_key])) {
                $type1_name .= $value;
            } else {
                $type2_name .= $value;
            }
        }

        $binary_data = $this->to_binary_data($data, $param_name, $combinations[$max_key], $type1_name, $type2_name);

        return $binary_data;
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
            $chk       = $array[$pred];
            $tmp_array = $array;
            if (in_array($chk, $comb)) {
                $tmp_array[$pred] = $name1;
            } else {
                $tmp_array[$pred] = $name2;
            }
            $tmp_data[$num] = $tmp_array;
        }

        return $tmp_data;
    }

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

        // Extract the number of individuals each value of the predictor variables
        $feat_array = ArrayService::get_sub_array_by_key($data, $base);

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
            if ($data_value[$index] === $value) {
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

        $decisionTreeData = self::makeDecisionTreeData($data, $base, $base_value, $split_key, $split_value);

        $decisionTreeNode           = new DecisionTreeNode($decisionTreeData);
        $decisionTreeNode->terminal = false;

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
            $decisionTreeNode->terminal = true;

            return $decisionTreeNode;
        }

        $split_key = array_search(max($delta_I_array), $delta_I_array);

        $split_array = ArrayService::split_by_key($data, $split_key);
        $i           = 0;
        foreach ($split_array as $key => $value) {
            if ($i === 0) {
                $decisionTreeNode->setLeft(self::make_decision_tree($value, $base, $base_value, $split_key, $key));
            } else {
                $decisionTreeNode->setRight(self::make_decision_tree($value, $base, $base_value, $split_key, $key));
            }

            $i++;
        }

        return $decisionTreeNode;
    }

    /**
     * @param $data
     * @param $base
     * @param $value
     * @param $split_key
     * @param $split_value
     * @return DecisionTreeData
     */
    private function makeDecisionTreeData($data, $base, $value, $split_key, $split_value)
    {
        $decisionTreeData              = new DecisionTreeData();
        $decisionTreeData->number      = count($data);
        $decisionTreeData->split_key   = $split_key;
        $decisionTreeData->split_value = $split_value;

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
