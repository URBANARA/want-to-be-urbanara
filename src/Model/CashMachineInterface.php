<?php
/**
 * @author Ondrej Führer <ondrej@fuhrer.cz>
 * @date 16.2.2017 13:51
 */

namespace Model;

/**
 * Class CashMachineInterface
 * @package Model
 */
interface CashMachineInterface
{
    /**
     * Return an array of notes for the given amount
     *
     * @param float $amount
     * @return float[]
     * @throws \InvalidArgumentException if the given amount is invalid (negative)
     */
    public function withdraw(float $amount): array;
}
