<?php

namespace Urbanara\CashMachine\Factory;

use Urbanara\CashMachine\Entity\Currency;
use Urbanara\CashMachine\Enum\Currency\UnitedStatesDollarEnum;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
class UnitedStatesDollarNoteFactory extends AbstractCurrencyNoteFactory
{
    /**
     * @return float[]
     */
    public function getAvailableValues()
    {
        return [
            100.00,
            50.00,
            20.00,
            10.00,
            5.00,
            2.00,
            1.00,
        ];
    }

    /**
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function buildCurrency()
    {
        return new Currency(
            UnitedStatesDollarEnum::ISO_4217,
            UnitedStatesDollarEnum::NAME,
            UnitedStatesDollarEnum::SYMBOL
        );
    }
}
