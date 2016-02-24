<?php

namespace Algorithms\ML;

use Algorithms\ML\Tokenizer\TokenizerInterface;

/**
 * Class Bayes
 * @package Algorithms\ML
 */
class Bayes
{
    /**
     * @var TokenizerInterface
     */
    protected $tokenizer;

    /**
     * @var array
     */
    protected $labels = array();

    /**
     * @var array
     */
    protected $docs = array();

    /**
     * @var array
     */
    protected $tokens = array();

    /**
     * @var array
     */
    protected $data = array();

    /**
     * Constructor.
     *
     * @param TokenizerInterface $tokenizer
     */
    public function __construct(TokenizerInterface $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    /**
     * Trains the classifier one text+label combination a time
     *
     * @param string $label
     * @param string $text
     */
    public function train($label, $text)
    {
        $tokens = $this->tokenizer->tokenize($text);

        foreach ($tokens as $token) {
            @$this->labels[$label]++;
            @$this->tokens[$token]++;
            @$this->data[$label][$token]++;
        }

        @$this->docs[$label]++;
    }

    /**
     * Classifies a text and returns the probability (score) per label
     *
     * @param  string $text
     * @return array
     */
    public function classify($text)
    {
        $totalDocCount = array_sum($this->docs);

        $tokens = $this->tokenizer->tokenize($text);

        $scores = array();

        foreach ($this->labels as $label => $labelCount) {
            $logSum = 0;

            $docCount = intval(@$this->docs[$label]);
            $inversedDocCount = $totalDocCount - $docCount;

            if (0 === $inversedDocCount) {
                continue;
            }

            foreach ($tokens as $token) {
                $totalTokenCount = intval(@$this->tokens[$token]);

                if (0 === $totalTokenCount) {
                    continue;
                }

                $tokenCount         = intval(@$this->data[$label][$token]);
                $inversedTokenCount = $this->inversedTokenCount($token, $label);

                $tokenProbabilityPositive = $tokenCount / $docCount;
                $tokenProbabilityNegative = $inversedTokenCount / $inversedDocCount;

                $probability = $tokenProbabilityPositive / ($tokenProbabilityPositive + $tokenProbabilityNegative);

                $probability = ((1 * 0.5) + ($totalTokenCount * $probability)) / (1 + $totalTokenCount);

                if (0 === $probability) {
                    $probability = 0.01;
                } elseif (1 === $probability) {
                    $probability = 0.99;
                }

                $logSum += log(1 - $probability) - log($probability);
            }

            $scores[$label] = 1 / (1 + exp($logSum));
        }

        arsort($scores, SORT_NUMERIC);

        return $scores;
    }

    /**
     * @param  string $token
     * @param  string $label
     * @return int
     */
    protected function inversedTokenCount($token, $label)
    {
        $data = $this->data;

        $totalTokenCount = $this->tokens[$token];

        $totalLabelTokenCount = intval(@$data[$label][$token]);

        $retval = $totalTokenCount - $totalLabelTokenCount;

        return $retval;
    }
}