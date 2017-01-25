<?php

namespace Urbanara\CashMachine\Factory;

use Urbanara\CashMachine\Enum\Currency\EuropeanEuroEnum;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
class EuropeanEuroNoteFactory extends AbstractCurrencyNoteFactory
{
    /**
     * @return float[]
     */
    public function getAvailableValues()
    {
        return [
            200.00,
            100.00,
            50.00,
            20.00,
            10.00,
            5.00,
        ];
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return EuropeanEuroEnum::ISO_4217;
    }
}
