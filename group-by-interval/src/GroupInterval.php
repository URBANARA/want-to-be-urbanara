<?php

namespace Urbanara;

/**
 * Class GroupInterval
 * @package Urbanara
 */
class GroupInterval
{
    /**
     * @param int $range
     * @param array $numberSet
     * @return array
     */
    public static function order(?int $range, ?array $numberSet = [])
    {
        if (is_null($range) || is_null($numberSet)) {
            return [];
        }

        usort($numberSet, function ($a, $b) {
            return ($a < $b) ? -1 : 1;
        });

        $grouped = [];
        $key = 0;

        $first = reset($numberSet);
        $last = end($numberSet);
        $rangeSet = range($first, $last, $range);
        $rangeSet = array_merge($rangeSet, [end($rangeSet) + $range]);

        $lastNumber = $first;
        foreach ($rangeSet as $numberRange) {
            foreach ($numberSet as $keyNumber => $number) {
                if (!is_int($number)) {
                    throw new \InvalidArgumentException();
                }

                if (self::isRange($number, $lastNumber, $numberRange)) {
                    if (!isset($grouped[$key])) {
                        $grouped[$key] = [];
                    }

                    if (!in_array($number, $grouped[$key])) {
                        $grouped[$key] = array_merge($grouped[$key], [$number]);
                        unset($numberSet[$keyNumber]);
                    }
                } else {
                    $key++;
                }
            }
        }

        return array_values($grouped);
    }

    /**
     * @param int $value
     * @param $min
     * @param $max
     * @return bool
     */
    protected static function isRange(int $value, $min, $max)
    {
        return in_array($value, range($min, $max));
    }
}
