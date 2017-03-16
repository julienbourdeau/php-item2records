<?php

namespace Algolia\Utils;

class Length
{
    public function ofArray(array $array)
    {
        $isAssoc = $this->isAssociativeArray($array);
        if ($isAssoc) {
            $content = $this->ofAssociativeArray($array);
        } else {
            $content = $this->ofNonAssociativeArray($array);
        }

        $count = count($array);
        if ($isAssoc) {
            $jsonSyntax = 2 + $count + $count - 1; // Brackets + colons  + commas
        } else {
            $jsonSyntax = 2 + ($count - 1); // Square brackets + commas
        }

        return $content + $jsonSyntax;
    }

    private function ofNonAssociativeArray($array)
    {
        $valLength = 0;
        foreach ($array as $value) {
            $valLength += $this->getArrayValueLength($value);
        }

        return $valLength;
    }

    private function ofAssociativeArray($array)
    {
        $keyLength = 0;
        $valLength = 0;
        foreach ($array as $key => $value) {
            $keyLength += $this->getArrayKeyLength($key);
            $valLength += $this->getArrayValueLength($value);
        }

        return $keyLength + $valLength;
    }

    private function getArrayKeyLength($key)
    {
        if (is_int($key) || is_string($key)) {
            return strlen($key) + 2;
        } else {
            throw new \Exception('Invalid array key.');
        }
    }

    /**
     * @param $value
     * @return int
     * @throws \Exception
     */
    private function getArrayValueLength($value)
    {
        if (is_int($value) || is_float($value)) {
            return strlen($value);
        } elseif (is_string($value)) {
            return strlen($value) + 2;
        } elseif (is_array($value)) {
            return $this->ofArray($value);
        } else {
            throw new \Exception('Invalid array.');
        }
    }

    private function isAssociativeArray(array $arr)
    {
        if (empty($arr)) {
            return true;
        }

        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}