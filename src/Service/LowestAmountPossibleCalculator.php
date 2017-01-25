<?php

namespace Urbanara\CashMachine\Service;

use InvalidArgumentException;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Service
 */
class LowestAmountPossibleCalculator
{
    /**
     * Returns the lowest division or an empty array when it isn't possible to divide
     *
     * @param float   $amount
     * @param float[] $divisors
     *
     * @return array
     */
    public function findLowestDistribution($amount, array $divisors)
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Amount must be a positive number');
        }

        // Just to make sure that the divisors are ordered
        arsort($divisors);

        $result = [];
        $currentAmount = $amount;

        foreach ($divisors as $divisor) {
            $times = $this->findHowManyTimesItIsDivisible($currentAmount, $divisor);

            if (0 == $times) {
                continue;
            }

            $currentAmount -= $divisor * $times;
            $result = array_merge(
                $result,
                array_fill(0, $times, $divisor)
            );

            if (0 == $currentAmount) {
                return $result;
            }
        }

        // Removes the greatest divisor to try again
        array_shift($divisors);

        // Unable to divide
        if (empty($divisors)) {
            return [];
        }

        return $this->findLowestDistribution($amount, $divisors);
    }

    /**
     * @param float $amount
     * @param float $divisor
     *
     * @return integer
     */
    private function findHowManyTimesItIsDivisible($amount, $divisor)
    {
        if ($divisor > $amount) {
            return 0;
        }

        return floor($amount / $divisor);
    }
}
