<?php

namespace Urbanara\CashMachine;


class BanknotesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var BanknotesInterface
     */
    private $banknotes;

    public function setUp()
    {
        $this->banknotes = new Banknotes();
    }

    public function testGetGreater()
    {
        $this->assertEquals(100, $this->banknotes->getGreater());
    }

    public function testFilterMaxValue()
    {
        $this->banknotes->filterMaxValue(10);
        $this->assertEquals(array(10), $this->banknotes->getBanknotes());
    }
}