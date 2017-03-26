<?php

namespace Yatikh\CashMachine\Test;

use PHPUnit\Framework\TestCase;
use Yatikh\CashMachine\Service\Machine;

/**
 * Unit tests for Machine service.
 *
 * @author Yaroslav Tikhomirov <yartikh@gmail.com>
 */
class MachineTest extends TestCase
{
    protected $machine;

    public function setUp()
    {
        $this->machine = new Machine();
    }

    public function testGetCash()
    {
        $this->assertEquals([20.00, 10.00], $this->machine->getCash(30.0));
        $this->assertEquals([50.00, 20.00, 10.00], $this->machine->getCash(80.0));
        $this->assertEquals([100, 100, 50.00, 20.00], $this->machine->getCash(270.0));
        $this->assertEquals([], $this->machine->getCash(null));
        $this->assertEquals([], $this->machine->getCash(0));
    }

    /**
     * @expectedException Yatikh\CashMachine\Exception\NoteUnavailableException
     */
    public function testGetCashWithUnavailableNote()
    {
        $this->machine->getCash(125.00);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetCashWithNegativeAmount()
    {
        $this->machine->getCash(-130.00);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetCashWithIncorrectAmount()
    {
        $this->machine->getCash('twenty');
    }
}