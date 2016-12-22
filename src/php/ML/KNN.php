<?php

namespace Algorithms\ML;

use Algorithms\Base\Schema;
use Algorithms\Node\DistanceNode;

class KNN
{
    /**
     * @var DistanceNode[]
     */
    protected $nodes;

    /**
     * @var int
     */
    protected $k;

    /**
     * @var Schema
     */
    protected $schema;

    /**
     * Constructor.
     *
     * @param int    $k
     * @param Schema $schema
     */
    public function __construct($k = 3, Schema $schema)
    {
        $this->k = $k;
        $this->nodes = array();
        $this->schema = $schema;
    }

    /**
     * @param DistanceNode $node
     * @return $this
     */
    public function add(DistanceNode $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @param  DistanceNode   $node
     * @param  string $field
     * @return mixed
     */
    public function guess(DistanceNode $node, $field)
    {
        $this->calculateDistances($node);

        $this->sort();

        $hits = array();

        /** @var DistanceNode[] $nearest */
        $nearest = array_slice($this->nodes, 0, $this->k);
        foreach ($nearest as $neighbor) {
            if (!isset($hits[$neighbor->getField($field)])) {
                $hits[$neighbor->getField($field)] = 0;
            }

            $hits[$neighbor->getField($field)] += 1;
        }

        $result = null;
        $max_hit = 0;

        foreach ($hits as $value => $count) {
            if ($count > $max_hit) {
                $max_hit = $count;
                $result = $value;
            }
        }

        return $result;
    }

    /**
     * Calculates ranges for each field
     */
    protected function calculateRanges()
    {
        $ranges = array();

        foreach ($this->schema->getFields() as $field) {
            $min = INF;
            $max = 0;

            foreach ($this->nodes as $node) {
                if ($node->getField($field) < $min) {
                    $min = $node->getField($field);
                }

                if ($node->getField($field) > $max) {
                    $max = $node->getField($field);
                }
            }

            $ranges[$field] = $max - $min;
        }

        return $ranges;
    }

    /**
     * Sorts nodes by distance
     *
     */
    protected function sort()
    {
        usort(
            $this->nodes,
            function (DistanceNode $a, DistanceNode $b) {
                return $a->getDistance() > $b->getDistance();
            }
        );
    }

    /**
     * Calculates distances
     *
     * @param DistanceNode   $node
     */
    protected function calculateDistances(DistanceNode $node)
    {
        $ranges = $this->calculateRanges();

        foreach ($this->nodes as $neighbor) {
            $deltas = array();

            foreach ($this->schema->getFields() as $field) {
                $range = $ranges[$field];

                $delta = $neighbor->getField($field) - $node->getField($field);
                $delta = $delta / $range;

                $deltas[$field] = $delta;
            }

            $total = 0;
            foreach ($deltas as $delta) {
                $total += $delta * $delta;
            }

            $neighbor->setDistance(sqrt($total));
        }
    }
}