<?php

namespace Algorithms\Node;

use Algorithms\Base\BaseNode;

class DistanceNode extends BaseNode
{
    /**
     * @var int
     */
    protected $distance;

    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->distance = 0;
    }

    /**
     * @param $field
     * @return null
     */
    public function getField($field)
    {
        if (!isset($this->data[$field])) {
            return null;
        }

        return $this->data[$field];
    }

    /**
     * @param $distance
     * @return $this
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }
}