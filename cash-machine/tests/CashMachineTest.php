<?php

use PHPUnit\Framework\TestCase;
use Urbanara\CashMachine;

/**
 * Class CashMachineTest
 */
class CashMachineTest extends TestCase
{
    public function testCashOutPositive()
    {
        $this->assertEquals([20.00, 10.00], CashMachine::out(30));
        $this->assertEquals([50.00, 20.00, 10.00], CashMachine::out(80));
        $this->assertEquals([], CashMachine::out(null));
    }

    /**
     * @expectedException \Urbanara\Exception\NoteUnavailableException
     */
    public function testUnavailable()
    {
        $this->assertTrue(CashMachine::out(125.00));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgument()
    {
        $this->assertTrue(CashMachine::out(-130.00));
    }
}
