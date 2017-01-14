<?php

namespace GroupByInterval\Grouper;

use InvalidArgumentException;

class Grouper
{
    /**
     * @var int
     */
    protected $range;

    /**
     * @var array
     */
    protected $number_set;

    /**
     * Grouper constructor.
     * @param int $range
     * @param array $number_set
     */
    public function __construct(int $range, array $number_set)
    {
        $this->range = $range;
        $this->number_set = $number_set;
    }

    /**
     * Return set of number grouped
     * @return array
     */
    public function result(): array
    {
        $result = [];

        $number_set = $this->orderNumberSet();

        $first = current($number_set);

        $point = $this->getInitPoint($first);

        while ($number = current($number_set)) {

            $this->validateNumber($number);

            $group = $this->groupInRange($point, $number_set);

            if ($group) {
                $result[] = $group;
            }

            $point += $this->range;
        }

        return $result;
    }

    /**
     * Order initial number set
     *
     * @return array
     */
    protected function orderNumberSet(): array
    {
        sort($this->number_set);

        return array_map(function ($number) {

            $this->validateNumber($number);

            return $number;

        }, $this->number_set);
    }

    /**
     * Get group in range of number set
     *
     * @param int $point
     * @param array $number_set
     * @return array
     */
    protected function groupInRange(int $point, array &$number_set)
    {
        $group = [];

        foreach ($number_set as $key => $number) {

            if ($number <= $point) {

                $group[] = $number;
                unset($number_set[$key]);
                continue;
            }
        }

        return $group;
    }

    /**
     * Get the init reference point
     *
     * @param int $first
     * @return int
     */
    protected function getInitPoint(int $first): int
    {
        $init = $this->range;

        while ($init > $first) {
            $init -= $this->range;
        }

        return $init;
    }

    /**
     * Validate number
     *
     * @param $number
     */
    protected function validateNumber($number)
    {
        if (!is_numeric($number)) {

            throw new InvalidArgumentException('Invalid argument: ' . $number);
        }
    }

}