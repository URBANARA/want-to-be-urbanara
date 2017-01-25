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
     * @var \Urbanara\CashMachine\Factory\CurrencyFactory
     */
    protected $currencyFactory;

    /**
     * AbstractCurrencyNoteFactory constructor.
     *
     * @param \Urbanara\CashMachine\Factory\CurrencyFactory $currencyFactory
     */
    public function __construct(CurrencyFactory $currencyFactory)
    {
        $this->currencyFactory = $currencyFactory;
    }

    /**
     * @return \Urbanara\CashMachine\Entity\CurrencyNote[]
     */
    public function getAvailableCurrencyNotes()
    {
        $currency = $this->currencyFactory->buildByIso4217Code($this->getCurrencyCode());
        $availableCurrencyNotes = [];

        foreach ($this->getAvailableValues() as $currencyNoteValue) {
            $availableCurrencyNotes[] = new CurrencyNote($currency, $currencyNoteValue);
        }

        return $availableCurrencyNotes;
    }
}
