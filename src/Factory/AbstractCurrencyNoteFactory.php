<?php

namespace Urbanara\CashMachine\Factory;

use Urbanara\CashMachine\Entity\CurrencyNote;

/**
 * Subclasses must define the available notes for a currency
 *
 * @author  Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Factory
 */
abstract class AbstractCurrencyNoteFactory implements DefineCurrencyValuesInterface
{
    /**
     * @var \Urbanara\CashMachine\Entity\Currency
     */
    protected $currency;

    /**
     * AbstractCurrencyNoteFactory constructor.
     */
    public function __construct()
    {
        $this->currency = $this->buildCurrency();
    }

    /**
     * @return \Urbanara\CashMachine\Entity\CurrencyNote[]
     */
    public function getAvailableCurrencyNotes()
    {
        $availableCurrencyNotes = [];

        foreach ($this->getAvailableValues() as $currencyNoteValue) {
            $availableCurrencyNotes[] = new CurrencyNote($this->currency, $currencyNoteValue);
        }

        return $availableCurrencyNotes;
    }

    /**
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }
}
