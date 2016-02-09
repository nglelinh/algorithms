<?php

namespace Algorithms\ML;

/**
 * Interface DecisionTreeInterface
 * @package Algorithms\ML
 */
interface DecisionTreeInterface {
    /**
     * @param $base_key
     * @param $base_value
     * @param $false_value
     * @return mixed
     */
    public function classify($base_key,$base_value,$false_value);

    /**
     * @param $target
     * @return mixed
     */
    public function prognosis($target);
}
