<?php

namespace Urbanara\CashMachine\Factory;

/**
 * Interface to define the available notes for a currency
 *
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
interface DefineCurrencyValuesInterface
{
    /**
     * @return float[]
     */
    public function getAvailableValues();

    /**
     * @return string
     */
    public function getCurrencyCode();
}
