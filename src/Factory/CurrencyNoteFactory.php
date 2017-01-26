<?php

namespace Urbanara\CashMachine\Factory;

use InvalidArgumentException;
use Urbanara\CashMachine\Enum\Currency\BrazilianRealEnum;
use Urbanara\CashMachine\Enum\Currency\EuropeanEuroEnum;
use Urbanara\CashMachine\Enum\Currency\UnitedStatesDollarEnum;

/**
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
class CurrencyNoteFactory
{
    /**
     * @param string $iso4217
     *
     * @return \Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory
     */
    public function buildByIso4217Code($iso4217)
    {
        switch ($iso4217) {
            case BrazilianRealEnum::ISO_4217:
                return $this->buildBrazilianReal();

            case EuropeanEuroEnum::ISO_4217:
                return $this->buildEuropeanEuro();

            case UnitedStatesDollarEnum::ISO_4217:
                return $this->buildUnitedStatesDollar();
        }

        throw new InvalidArgumentException("The ISO-4217 code ({$iso4217}) isn't supported");
    }

    /**
     * @return \Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory
     */
    public function buildBrazilianReal()
    {
        return new BrazilianRealNoteFactory();
    }

    /**
     * @return \Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory
     */
    public function buildEuropeanEuro()
    {
        return new EuropeanEuroNoteFactory();
    }

    /**
     * @return \Urbanara\CashMachine\Factory\AbstractCurrencyNoteFactory
     */
    public function buildUnitedStatesDollar()
    {
        return new UnitedStatesDollarNoteFactory();
    }
}
