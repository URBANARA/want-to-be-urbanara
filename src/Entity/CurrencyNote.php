<?php

namespace Urbanara\CashMachine\Entity;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Entity
 */
class CurrencyNote extends AbstractEntity
{
    /**
     * @var \Urbanara\CashMachine\Entity\Currency
     */
    private $currency;

    /**
     * @var float
     */
    private $value;

    /**
     * CurrencyNote constructor.
     *
     * @param \Urbanara\CashMachine\Entity\Currency $currency
     * @param float                                 $value
     */
    public function __construct(Currency $currency, $value)
    {
        $this->currency = $currency;
        $this->value = $value;
    }

    /**
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param \Urbanara\CashMachine\Entity\Currency $currency
     *
     * @return \Urbanara\CashMachine\Entity\CurrencyNote
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     *
     * @return \Urbanara\CashMachine\Entity\CurrencyNote
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
