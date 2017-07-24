<?php

namespace Urbanara;

use \InvalidArgumentException;

/**
 * Class Solution
 * @package Urbanara
 */
class Solution
{
    /**
     * @param array     $input
     * @param int|null  $range
     *
     * @throws InvalidArgumentException
     * @return array
     */
    public function groupByRange(array $input, ?int $range): array
    {
        $result = [];

        if (!is_null($range) && $range > 0 && count($input) > 0) {

            foreach ($input as $item) {

                if (!is_int($item)) {
                    throw new InvalidArgumentException();
                }

                $rangeIndex = $item / $range;
                $rangeIndexAsInt = (int) $rangeIndex;
                $difference = $rangeIndexAsInt - $rangeIndex;

                if (
                    ($difference == 0 && $item > 0)
                    || ($difference != 0 && $item < 0)
                ) {
                    $rangeIndexAsInt--;
                }

                if (!isset($result[$rangeIndexAsInt])) {
                    $result[$rangeIndexAsInt] = [];
                }

                $result[$rangeIndexAsInt] = $this->insert($result[$rangeIndexAsInt], $item);
            }
        }

        ksort($result);

        return array_values($result);
    }

    /**
     * @param array $input
     * @param int   $item
     *
     * @return array
     */
    private function insert(array $input, int $item): array
    {
        $result = [];
        $length = count($input);
        $isAppended = false;

        if ($length > 0) {

            foreach ($input as $key => $value) {
                $isLastValue = ($key + 1) == $length;

                if ($isLastValue) {

                    if ($item >= $value) {
                        $result[] = $value;
                        $result[] = $item;
                    } else {
                        $result[] = $item;
                        $result[] = $value;
                    }

                    $isAppended = true;
                    continue;
                }

                $result[] = $value;
            }
        }

        if (!$isAppended) {
            $result[] = $item;
        }

        return $result;
    }
}
