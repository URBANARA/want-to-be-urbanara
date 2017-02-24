<?php
declare(strict_types=1);

namespace Sibirtsev\Urbanara;

use PHPUnit\Framework\TestCase;

class CacheMachineTest extends TestCase
{
    public function testCreateCacheMachine()
    {
        $cache_machine = new CacheMachine();
        $this->assertTrue($cache_machine instanceof CacheMachine);
        $this->assertEquals([100, 50, 20, 10], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithCustomNotes()
    {
        $cache_machine = new CacheMachine([10, 5, 3]);
        $this->assertTrue($cache_machine instanceof CacheMachine);
        $this->assertEquals([10, 5, 3], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithCustomOrderedNotes()
    {
        $cache_machine = new CacheMachine([1, 3, 2]);
        $this->assertTrue($cache_machine instanceof CacheMachine);
        $this->assertEquals([3, 2, 1], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithBadNotes()
    {
        $cache_machine = new CacheMachine([10, 5, 'a']);
        $this->assertTrue($cache_machine instanceof CacheMachine);
        $this->assertEquals([10, 5], $cache_machine->getAvailableNotes());
    }

    public function testCreateCacheMachineWithAllBadNotes()
    {
        $cache_machine = new CacheMachine(['a', 'b', 'z']);
        $this->assertTrue($cache_machine instanceof CacheMachine);
        $this->assertEquals([100, 50, 20, 10], $cache_machine->getAvailableNotes());
    }

    public function testWithdrawWithEmptyAmount()
    {
        $cache_machine = new CacheMachine();
        $this->assertEquals([], $cache_machine->withdraw(null));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWithdrawWithNegativeAmount()
    {
        $cache_mathine = new CacheMachine();
        $cache_mathine->withdraw(-130);
    }

    public function testWithdrawCommonWay()
    {
        $cache_machine = new CacheMachine();
        $this->assertEquals([20, 10], $cache_machine->withdraw(30));
        $this->assertEquals([50, 20, 10], $cache_machine->withdraw(80));
        $this->assertEquals([50, 20, 20], $cache_machine->withdraw(90));
    }

    /**
     * @expectedException Sibirtsev\Urbanara\NoteUnavailableException
     */
    public function testWithdrawWithRemainder()
    {
        $cache_machine = new CacheMachine();
        $cache_machine->withdraw(125);
    }
}
