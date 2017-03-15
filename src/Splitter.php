<?php

namespace Algolia\Item2Records;

class Splitter {

    private $attributeName;
    private $attributeMaxSizeInByte;
    private $recordMaxSizeInByte;

    function __construct($attributeName, $attributeMaxSizeInByte = 600, $recordMaxSizeInByte = 2000)
    {
        $this->attributeName = $attributeName;
        $this->attributeMaxSizeInByte = $attributeMaxSizeInByte;
        $this->recordMaxSizeInByte = $recordMaxSizeInByte;
    }

    public function itemsToRecords(array $items)
    {
        $records = [];

        foreach ($items as $item) {
            $records = array_merge($records, $this->itemToRecords($item));
        }

        return $records;
    }

    public function itemToRecords(array $item)
    {
        $records = [];

        if (strlen(json_encode($item)) < $this->recordMaxSizeInByte) {
            return [$item];
        }

        $splitAttributes = $this->splitAttribute($item[$this->attributeName]);

        foreach ($splitAttributes as $val) {
            $item[$this->attributeName] = $val;

            $records[] = $item;
        }

        return $records;
    }

    public function splitAttribute($attr)
    {
        while (true) {
            $attr = trim($attr);
            if (mb_strlen($attr) <= $this->attributeMaxSizeInByte) {
                $values[] = $attr;

                return $values;
            }

            $cutAtPosition = mb_strpos($attr, ' ', $this->attributeMaxSizeInByte);
            if (false === $cutAtPosition) {
                $cutAtPosition = $this->attributeMaxSizeInByte;
            }

            $values[] = mb_strcut($attr, 0, $cutAtPosition);
            $attr = mb_strcut($attr, $cutAtPosition);
        }
    }
}