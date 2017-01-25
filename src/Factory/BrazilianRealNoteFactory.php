<?php

namespace Urbanara\CashMachine\Factory;

use Urbanara\CashMachine\Enum\Currency\BrazilianRealEnum;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
class BrazilianRealNoteFactory extends AbstractCurrencyNoteFactory
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
        ];
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return BrazilianRealEnum::ISO_4217;
    }
}
