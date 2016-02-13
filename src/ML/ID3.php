<?php

namespace Algorithms\ML;

use Algorithms\Linear\InvalidArgumentException;
use Algorithms\Service\ArrayService;

/**
 * Class Tree
 * @package Algorithms\ML
 */
class Tree
{
    /**
     * @var
     */
    protected $root;

    /**
     * Tree constructor.
     * @param $root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     *
     */
    public function display()
    {
        $this->root->display(0);
    }
}

/**
 * Class Node
 * @package Algorithms\ML
 */
class Node
{
    /**
     * @var
     */
    public $value;
    /**
     * @var array
     */
    public $namedBranches;

    /**
     * Node constructor.
     * @param $new_item
     */
    public function __construct($new_item)
    {
        $this->value         = $new_item;
        $this->namedBranches = [];
    }

    /**
     * @param $level
     */
    public function display($level)
    {
        echo $this->value . "\n";
        foreach ($this->namedBranches as $b => $child_node) {
            echo str_repeat(" ", ($level + 1) * 4) . str_repeat("-", 14 / 2 - strlen($b) / 2) . $b . str_repeat("-",
                    14 / 2 - strlen($b) / 2) . ">";
            $child_node->display($level + 1);
        }
    }

    /**
     * @return mixed
     */
    public function get_parent()
    {
        return ($this->tree);
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
     */
    public function predict_outcome($input_data)
    {
        $data = $input_data['samples'];
        foreach ($data as $k => $row) {
            $row['result'] = $this->predict($this->root, $row);
            $data[$k]      = $row;
        }
        echo "\n";
        print_r($data);
    }

    /**
     * @param \Algorithms\Base\NodeInterface $training_data
     */
    public function setTrainingData($training_data)
    {
        $this->training_data = $training_data;
        array_pop($this->training_data['header']);
        $this->find_root($this->root, 'Any', $this->training_data);
    }

    /**
     * @param $node
     * @param $data_row
     * @return null
     */
    private function predict($node, $data_row)
    {
        //we have reached a leaf node
        if (!count($node->namedBranches)) {
            print_r("\nReturning " . $node->value);

            return $node->value;
        }
        if (array_key_exists($node->value, $data_row)) {
            print_r("\nValue of " . $node->value . " is " . $data_row[$node->value]);
            if (array_key_exists($data_row[$node->value], $node->namedBranches)) {
                print_r("\nBranch " . $data_row[$node->value] . " exists and leads to node " . $node->namedBranches[$data_row[$node->value]]->value);
                $next_node = $node->namedBranches[$data_row[$node->value]];

                return ($this->predict($next_node, $data_row));
            }
        }
        print_r("\nInvalid path");

        return null;
    }

    /**
     * @param $parent_node
     * @param $branch_name
     * @param $training_data
     */
    private function find_root($parent_node, $branch_name, $training_data)
    {
        $samples = $training_data['samples'];
        $header  = $training_data['header'];

        $p = $this->possible_values($samples, 'value');
        if (count($p) == 1) {
            reset($p);
            $parent_node->namedBranches[$branch_name] = new Node(strtoupper(key($p)));

            return;
        }
        $winning_attribute = 'none';
        foreach (array_keys($header) as $h) {
            $g = $this->gain($samples, $h);
            if (empty($max_gain) || ($g > $max_gain)) {
                $max_gain          = $g;
                $winning_attribute = $h;
            }
        }
        if ($parent_node->value != 'Root') {
            $parent_node->namedBranches[$branch_name] = new Node($winning_attribute);
            $parent_node                              = $parent_node->namedBranches[$branch_name];
        } else {
            $parent_node->value = $winning_attribute;
        }

        $p = $this->possible_values($samples, $winning_attribute);
        foreach ($p as $value => $count) {
            $subset = ArrayService::create_subset($training_data, $winning_attribute, $value);
            $this->find_root($parent_node, $value, $subset);
        }

        return;
    }

    /**
     * @param $samples
     * @param $attr
     * @return int
     */
    private function gain($samples, $attr)
    {
        $gain_reduction = 0.0;
        $total_count    = count($samples);

        $possible_values_count = $this->possible_values($samples, $attr);
        foreach ($possible_values_count as $k => $v) {
            $e = $this->entropy($samples, $attr, $k);
            $gain_reduction += $v * $e / $total_count;
        }
        $e   = $this->entropy($samples);
        $ret = $e - $gain_reduction;

        return $ret;
    }

    /**
     * @param      $samples
     * @param null $attr
     * @param null $value
     * @return int
     */
    private function entropy($samples, $attr = null, $value = null)
    {
        if ($attr != null) {
            $possibility = $this->calculate_p($samples, $attr, $value);
        } else {
            $possibility = $this->calculate_p($samples, null, null);
        }
        $ret = ($possibility['yes'] ? -$possibility['yes'] * log($possibility['yes'], 2) : 0) - ($possibility['no'] ? $possibility['no'] * log($possibility['no'], 2) : 0);

        return $ret;
    }

    /**
     * @param $samples
     * @param $attr
     * @param $attr_value
     * @return array
     * @throws InvalidArgumentException
     */
    private function calculate_p($samples, $attr, $attr_value)
    {
        $possibility = ['no' => 0, 'yes' => 0];
        try {
            foreach ($samples as $sample) {
                if ($attr == null) {
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

    /**
     * @param $samples
     * @param $attr
     * @return array
     */
    private function possible_values($samples, $attr)
    {
        $possible_values_count = [];
        foreach ($samples as $sample) {
            $possible_values_count[$sample[$attr]] = array_key_exists($sample[$attr],
                $possible_values_count) ? $possible_values_count[$sample[$attr]] + 1 : 1;
        }

        return $possible_values_count;
    }

}
