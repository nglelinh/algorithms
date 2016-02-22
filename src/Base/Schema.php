<?php

namespace Algorithms\Base;

class Schema
{
    /**
     * @var string[]
     */
    protected $fields = array();

    /**
     * @param string $field
     * @return $this
     */
    public function addField($field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFields()
    {
        return $this->fields;
    }
}