<?php
declare(strict_types=1);

namespace Usama;

/**
 * Class GroupByInterval
 * @package Usama
 */
class GroupByInterval
{
    /** @var array */
    protected $bins = [];

    /**
     * @param array $list
     * @param int|null $range
     * @return array
     */
    public function group(array $list = [], int $range = null) : array
    {
        $this->bins = [];
        $data = $this->prepare_data($list);

        foreach ($data as $item) {
            $bin = $this->get_bin_id($item, $range);
            $this->add_to_bin($bin, $item);
        }

        return array_values(array_filter($this->bins, function ($x) {
            return count($x) > 0;
        }));
    }

    /**
     * Check and sort numbers
     *
     * @param array $list
     * @return array
     */
    protected function prepare_data(array $list = []) : array
    {
        $data = [];
        foreach ($list as $item) {
            if (!is_int($item)) {
                throw new \InvalidArgumentException();
            }
            $data[] = $item;
        }
        return self::qsort($data);
    }

    /**
     * Calculate bin identifier
     *
     * @param int $item
     * @param int $range
     * @return int
     */
    protected function get_bin_id($item, $range)
    {
        $add = (($item % $range) > 0) ? 1 : 0;
        return intval(floor($item / $range) + $add);
    }

    /**
     * Append value to bin
     *
     * @param int $bin
     * @param int $value
     */
    protected function add_to_bin($bin, $value)
    {
        if (!array_key_exists($bin, $this->bins)) {
            $this->bins[$bin] = [];
        }
        $this->bins[$bin][] = $value;
    }

    /**
     * Simple quicksort
     *
     * @param array $array
     * @param bool $ascending
     * @return array
     */
    public static function qsort(array $array, $ascending = true) : array
    {
        if (count($array) < 2) {
            return $array;
        }
        $left = $right = [];
        // Get first element for pivot
        reset($array);
        $pivot_key = key($array);
        $pivot  = array_shift($array);

        // Build left and right parts
        foreach ($array as $key => $value) {
            if ($value < $pivot) {
                $left[$key] = $value;
            } else {
                $right[$key] = $value;
            }
        }

        // Call recursive qsort for left and right part of array
        if ($ascending) {
            // for ascending
            return array_merge(
                self::qsort($left, $ascending),
                [$pivot_key => $pivot],
                self::qsort($right, $ascending)
            );
        }
        // for descending
        return array_merge(
            self::qsort($right, $ascending),
            [$pivot_key => $pivot],
            self::qsort($left, $ascending)
        );
    }
}
