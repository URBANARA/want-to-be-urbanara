<?php

namespace Urbanara\CashMachine;

use PHPUnit_Framework_TestCase;

class CashMachineTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Urbanara\CashMachine\CashMachineInterface
     */
    private $cashMachine;

    protected function setUp()
    {
        $this->cashMachine = new CashMachine(
            new Banknotes()
        );
    }

    public function testExecute30()
    {
        $this->assertEquals(
            array(20, 10),
            $this->cashMachine->execute(30)
        );
    }

    public function testExecute80()
    {
        $this->assertEquals(
            array(50, 20, 10),
            $this->cashMachine->execute(80)
        );
    }

    public function testExecuteNull()
    {
        $this->assertEmpty(
            $this->cashMachine->execute(null)
        );
    }

    /**
     * @expectedException \Urbanara\CashMachine\Exception\NoteUnavailableException
     */
    public function testExecute125Exception()
    {
        $this->cashMachine->execute(125);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExecuteNegativeException()
    {
        $this->cashMachine->execute(-130);
    }
}
