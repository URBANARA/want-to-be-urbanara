<?php

namespace Tests\Urbanara\CashMachine;

use Urbanara\CashMachine\CashMachine;
use Urbanara\CashMachine\Exception\InvalidArgumentException;

class CashMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $notes;

    protected function setUp()
    {
        parent::setUp();

        $this->notes = [10, 20, 50, 100];
    }

    public function testConstructOnEmptyNotes()
    {
        $this->expectException(InvalidArgumentException::class);
        new CashMachine([]);
    }

    public function testConstructOnInvalidNotes()
    {
        $this->expectException(InvalidArgumentException::class);
        new CashMachine([-1]);
    }

    public function testConstruct()
    {
        new CashMachine($this->notes);
    }

    public function testGetNotesDesc()
    {
        $cashMachine = new CashMachine($this->notes);
        $notes = $cashMachine->getNotesDesc();

        rsort($this->notes);

        $this->assertEquals($this->notes, $notes);
    }

    public function testGetNotes()
    {
        $cashMachine = new CashMachine($this->notes);
        $notes = $cashMachine->getNotes();

        $this->assertEquals($this->notes, $notes);
    }
}
