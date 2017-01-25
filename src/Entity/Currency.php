<?php

namespace Urbanara\CashMachine\Entity;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Entity
 */
class Currency extends AbstractEntity
{
    /**
     * @var string
     */
    private $iso4217;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $symbol;

    /**
     * Currency constructor.
     *
     * @param string $iso4217
     * @param string $name
     * @param string $symbol
     */
    public function __construct($iso4217, $name, $symbol)
    {
        $this->iso4217 = $iso4217;
        $this->name = $name;
        $this->symbol = $symbol;
    }

    /**
     * @return string
     */
    public function getIso4217()
    {
        return $this->iso4217;
    }

    /**
     * @param string $iso4217
     *
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function setIso4217($iso4217)
    {
        $this->iso4217 = $iso4217;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     *
     * @return \Urbanara\CashMachine\Entity\Currency
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }
}
