<?php

namespace Algorithms\ML\Tokenizer;

/**
 * Interface TokenizerInterface
 * @package Algorithms\ML\Tokenizer
 */
interface TokenizerInterface
{
    /**
     * @param $string
     * @return array
     */
    public function tokenize($string);
}