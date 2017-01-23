<?php

namespace Garbereder\Urbanara;

use \Garbereder\Urbanara\Machine;
use \Garbereder\Urbanara\NoteUnavailableException;

class MachineTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Machine $sut
     */
    protected $sut;

    public function setUp()
    {
        $this->sut = new Machine();
        $this->sut->setNotes([10, 20, 50, 100]);
    }

    public function testConstructor()
    {
        $machine = new Machine();
        $this->assertNotNull($machine);
    }

    public function testUnchanged()
    {
        $wd = 30;
        $this->sut->withdraw($wd);
        $this->assertEquals($wd, 30);
    }

    public function test50()
    {
        $result = $this->sut->withdraw(50);
        $this->assertEquals([50], $result);
    }

    public function testDecimal()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->sut->withdraw(10.5);
    }

    public function testDecimal2()
    {
        // add 0.5 note for this testcase only
        $this->sut->setNotes([10, 20, 50, 100, 0.5]);
        $result = $this->sut->withdraw(10.5);
        $this->assertEquals([10, 0.5], $result);
    }

    public function test0()
    {
        $result = $this->sut->withdraw(0);
        $this->assertEquals([], $result);
    }

    public function test30()
    {
        $result = $this->sut->withdraw(30);
        $this->assertEquals([20, 10], $result);
    }

    public function test90()
    {
        $result = $this->sut->withdraw(90);
        $this->assertEquals([50, 20, 20], $result);
    }

    public function test80()
    {
        $result = $this->sut->withdraw(80);
        $this->assertEquals([50, 20, 10], $result);
    }

    public function testNoteUnavailableException()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->sut->withdraw(125);
    }

    public function testInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sut->withdraw(-130);
    }

    public function testInvalidArgumentExceptionABC()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sut->withdraw("ABC");
    }

    public function testNull()
    {
        $result = $this->sut->withdraw(null);
        $this->assertEquals([], $result);
    }

    /**
     * Since the type of notes is a fixed and unlikely to change constraint a backtracing algorithm is not needed here,
     * but to build a general solution the algorithm has to be implemented in a backtracing manner.
     */
    public function _testBacktracing()
    {
        $this->sut->setNotes([9, 2]);
        $result = $this->sut->withdraw(10);
        $this->assertEquals([2, 2, 2, 2, 2], $result);
    }

}
