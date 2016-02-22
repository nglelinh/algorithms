<?php

use Algorithms\Base\Schema;
use Algorithms\ML\KNN;
use Algorithms\Node\DistanceNode;

class KnnTest extends PHPUnit_Framework_TestCase
{
    public function testGuess()
    {
        $schema = new Schema();
        $schema
            ->addField('rooms')
            ->addField('area')
        ;

        $dataset = new KNN(3, $schema);

        $dataset->add(new DistanceNode(array('rooms' => 1, 'area' => 350, 'type' => 'apartment')));
        $dataset->add(new DistanceNode(array('rooms' => 2, 'area' => 300, 'type' => 'apartment')));
        $dataset->add(new DistanceNode(array('rooms' => 3, 'area' => 300, 'type' => 'apartment')));
        $dataset->add(new DistanceNode(array('rooms' => 4, 'area' => 250, 'type' => 'apartment')));

        $dataset->add(new DistanceNode(array('rooms' => 7, 'area' => 850, 'type' => 'house')));
        $dataset->add(new DistanceNode(array('rooms' => 7, 'area' => 900, 'type' => 'house')));
        $dataset->add(new DistanceNode(array('rooms' => 7, 'area' => 1200, 'type' => 'house')));
        $dataset->add(new DistanceNode(array('rooms' => 8, 'area' => 1500, 'type' => 'house')));

        $dataset->add(new DistanceNode(array('rooms' => 1, 'area' => 800, 'type' => 'flat')));
        $dataset->add(new DistanceNode(array('rooms' => 3, 'area' => 900, 'type' => 'flat')));
        $dataset->add(new DistanceNode(array('rooms' => 2, 'area' => 700, 'type' => 'flat')));
        $dataset->add(new DistanceNode(array('rooms' => 1, 'area' => 900, 'type' => 'flat')));

        $this->assertEquals('flat', $dataset->guess(new DistanceNode(array('rooms' => 4, 'area' => 900)), 'type'));
        $this->assertEquals('house', $dataset->guess(new DistanceNode(array('rooms' => 7, 'area' => 900)), 'type'));
        $this->assertEquals('apartment', $dataset->guess(new DistanceNode(array('rooms' => 1, 'area' => 200)), 'type'));
    }
}