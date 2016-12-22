<?php

namespace Algorithms\ML\Tokenizer;

/**
 * Class Punctuation
 * @package Algorithms\ML\Tokenizer
 */
class Punctuation implements TokenizerInterface
{
    protected $pattern = "/[ ,.?!-:;\\n\\r\\t…_]/u";

    /**
     * @param $string
     * @return array
     */
    public function tokenize($string)
    {
        $returns = preg_split($this->pattern, mb_strtolower($string, 'utf8'));
        $returns = array_filter($returns, 'trim');
        $returns = array_values($returns);

        return $returns;
    }
}