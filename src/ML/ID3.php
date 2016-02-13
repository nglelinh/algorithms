<?php

namespace Algorithms\ML;

use Algorithms\Base\BaseNode;
use Algorithms\Base\BaseTree;
use Algorithms\Linear\InvalidArgumentException;
use Algorithms\Service\ArrayService;

/**
 * Class Tree
 * @package Algorithms\ML
 */
class Tree extends BaseTree
{
    public function display()
    {
        $this->root->display(0);
    }
}

/**
 * Class Node
 * @package Algorithms\ML
 */
class Node extends BaseNode
{
    /**
     * @var array
     */
    public $children;

    /**
     * Node constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data     = $data;
        $this->children = [];
    }

    /**
     * @param $level
     */
    public function display($level)
    {
        echo $this->getData() . "\n";
        /**
         * @var  Node $child_node
         */
        foreach ($this->children as $name => $child_node) {
            echo str_repeat(" ", ($level + 1) * 4) . str_repeat("-",
                    14 / 2 - strlen($name) / 2) . $name . str_repeat("-",
                    14 / 2 - strlen($name) / 2) . ">";
            $child_node->display($level + 1);
        }
    }
}

/**
 * Class ID3
 * @package Algorithms\ML
 */
class ID3 extends Tree
{
    /**
     * @var \Algorithms\Base\NodeInterface
     */
    private $training_data;

    /**
     * ID3 constructor.
     */
    public function __construct()
    {
        parent::__construct(new Node('Root'));
    }

    /**
     * @param $input_data
     * @return null
     */
    public function predict($input_data)
    {
        return $this->predict_node($this->root, $input_data);
    }

    /**
     * @param \Algorithms\Base\NodeInterface $training_data
     */
    public function classify($training_data)
    {
        $this->training_data = $training_data;
        array_pop($this->training_data['header']);
        $this->split_node($this->root, 'Any', $this->training_data);
    }

    /**
     * @param Node $node
     * @param      $data_row
     * @return null
     */
    private function predict_node(Node $node, $data_row)
    {
        //we have reached a leaf node
        if (!count($node->children)) {
            return $node->getData();
        }

        if (array_key_exists($node->getData(), $data_row)) {
            if (array_key_exists($data_row[$node->getData()], $node->children)) {
                $next_node = $node->children[$data_row[$node->getData()]];

                return ($this->predict_node($next_node, $data_row));
            }
        }

        return null;
    }

    /**
     * @param Node  $node
     * @param       $branch_name
     * @param array $training_data
     */
    private function split_node(Node $node, $branch_name, $training_data)
    {
        $samples = $training_data['samples'];
        $header  = $training_data['header'];

        $value_count = ArrayService::possible_values($samples, 'value');
        if (count($value_count) === 1) {
            $node->children[$branch_name] = new Node(strtoupper(key($value_count)));

            return;
        }

        $splitting_attribute = $max_gain = null;
        foreach (array_keys($header) as $h) {
            $g = $this->get_information_gain($samples, $h);
            if ($max_gain === null || ($g > $max_gain)) {
                $max_gain            = $g;
                $splitting_attribute = $h;
            }
        }

        if ($node->getData() != 'Root') {
            $node->children[$branch_name] = new Node($splitting_attribute);
            $node                         = $node->children[$branch_name];
        } else {
            $node->setData($splitting_attribute);
        }

        $value_count = ArrayService::possible_values($samples, $splitting_attribute);
        foreach ($value_count as $value => $count) {
            $subset = ArrayService::create_subset($training_data, $splitting_attribute, $value);
            $this->split_node($node, $value, $subset);
        }

        return;
    }

    /**
     * @param $samples
     * @param $attr
     * @return int
     */
    private function get_information_gain($samples, $attr)
    {
        $gain_reduction = 0.0;
        $total_count    = count($samples);

        $possible_values_count = ArrayService::possible_values($samples, $attr);
        foreach ($possible_values_count as $value => $count) {
            $e = $this->calculate_entropy($samples, $attr, $value);
            $gain_reduction += $count * $e / $total_count;
        }
        $e   = $this->calculate_entropy($samples);
        $ret = $e - $gain_reduction;

        return $ret;
    }

    /**
     * @param      $samples
     * @param null $attr
     * @param null $value
     * @return int
     */
    private function calculate_entropy($samples, $attr = null, $value = null)
    {
        $possibility = $this->calculate_possibility($samples, $attr, $value);

        $ret = ($possibility['yes'] ? -$possibility['yes'] * log($possibility['yes'], 2) : 0)
            - ($possibility['no'] ? $possibility['no'] * log($possibility['no'], 2) : 0);

        return $ret;
    }

    /**
     * @param $samples
     * @param $attr
     * @param $attr_value
     * @return array
     * @throws InvalidArgumentException
     */
    private function calculate_possibility($samples, $attr, $attr_value)
    {
        $possibility = ['no' => 0, 'yes' => 0];
        try {
            foreach ($samples as $sample) {
                if ($attr === null) {
                    $possibility[$sample['value']]++;
                } else {
                    if ($sample[$attr] == $attr_value) {
                        $possibility[$sample['value']]++;
                    }
                }
            }

            $total = $possibility['yes'] + $possibility['no'];

            if ($total != 0) {
                $possibility['yes'] /= $total;
                $possibility['no'] /= $total;
            } else {
                throw new InvalidArgumentException();
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
        }

        return ($possibility);
    }
}
