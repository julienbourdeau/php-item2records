<?php

namespace Algolia\Item2Records\Tests;

use Algolia\Item2Records\Length;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{
    /**
     * @param $array
     * @param $expectedLength
     *
     * @dataProvider providerTestOfArrayTest
     */
    public function testOfArrayTest($array, $expectedLength)
    {
        $length = new Length();

        $this->assertEquals($expectedLength, $length->ofArray($array));
    }

    public function providerTestOfArrayTest()
    {
        return array(
            array(array('test' => 'A'), 12),
            array(array('test', 'word', 'assoc'), 23),
            array(array('test', 'word', 'assoc', array('a', 'b', 'c')), 37),
            array(array('test' => '🤕'), 15),
        );
    }
}