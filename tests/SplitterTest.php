<?php

namespace Algolia\Item2Records\Tests;

use Algolia\Item2Records\Splitter;
use PHPUnit\Framework\TestCase;

class SplitterTest extends TestCase
{
    /**
     * @param $attributeToSplit A long string to split
     * @param $expectedSplitAttribute The string as an array, chuncked by the method
     *
     * @dataProvider providerTestSplitAttribute
     */
    public function testSplitAttribute($attributeToSplit, $expectedSplitAttribute)
    {
        $splitter = new Splitter('whatever');
        $returnedSplitAttribute = $splitter->splitAttribute($attributeToSplit);

        $this->assertEquals($expectedSplitAttribute, $returnedSplitAttribute);
    }

    public function providerTestSplitAttribute()
    {
        return json_decode(file_get_contents(__DIR__.'/data/simpleStrings.json'), true);
    }

    /**
     * @param $itemsToSplit
     * @param $expectedRecords
     *
     * @dataProvider providerTestItemToRecords
     */
    public function testItemToRecords($itemToSplit, $expectedRecords)
    {
        $splitter = new Splitter('bio');
        $returnedRecords = $splitter->itemToRecords($itemToSplit);

        $this->assertEquals($expectedRecords, $returnedRecords);
    }

    public function providerTestItemToRecords()
    {
        return json_decode(file_get_contents(__DIR__.'/data/itemsWithBio.json'), true);
    }


    /**
     * @param $itemsToSplit
     * @param $expectedRecords
     */
    public function testItemsToRecords()
    {
        $itemsToSplit = array('items' => array(), 'expected' => array());

        $data = json_decode(file_get_contents(__DIR__.'/data/itemsWithBio.json'), true);
        foreach ($data as $example) {
            $itemsToSplit['items'][] = $example['item'];
            $itemsToSplit['expected'] = array_merge($itemsToSplit['expected'], $example['expected']);
        }

        $splitter = new Splitter('bio');
        $returnedRecords = $splitter->itemsToRecords($itemsToSplit['items']);

        $this->assertEquals($itemsToSplit['expected'], $returnedRecords);
    }
}