<?php

namespace Algorithms\ML;

use Algorithms\Linear\InvalidArgumentException;
use Algorithms\Node\Tree\MultipleTreeNode;
use Algorithms\Service\ArrayService;
use Algorithms\Structure\MultipleTree;

/**
 * Class ID3
 * @package Algorithms\ML
 */
class ID3 extends MultipleTree
{
    /**
     * @param $input_data
     * @return null
     */
    public function predict($input_data)
    {
        return $this->predict_node($this->root, $input_data);
    }

    /**
     * @param array $training_data
     */
    public function classify($training_data)
    {
        $this->split_node($this->root, '', $training_data);
    }

    /**
     * @param MultipleTreeNode $node
     * @param      $data_row
     * @return null
     */
    private function predict_node(MultipleTreeNode $node, $data_row)
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
     * @param MultipleTreeNode  $node
     * @param       $branch_name
     * @param array $training_data
     */
    private function split_node(MultipleTreeNode $node, $branch_name, $training_data)
    {
        $samples = $training_data['samples'];
        $header  = $training_data['header'];

        $value_count = ArrayService::count_values($samples, 'value');

        if (count($value_count) === 1) {
            $node->children[$branch_name] = new MultipleTreeNode(strtoupper(key($value_count)));

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

        if ($node->getData() !== null) {
            $node->children[$branch_name] = new MultipleTreeNode($splitting_attribute);
            $node                         = $node->children[$branch_name];
        } else {
            $node->setData($splitting_attribute);
        }

        $value_count = ArrayService::count_values($samples, $splitting_attribute);
        foreach ($value_count as $value_name => $count) {
            $subset = ArrayService::create_subset($training_data, $splitting_attribute, $value_name);
            $this->split_node($node, $value_name, $subset);
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
        $gain_reduction = 0;
        $total_count    = count($samples);

        $possible_values_count = ArrayService::count_values($samples, $attr);
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
