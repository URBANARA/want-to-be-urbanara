<?php

namespace CashMachine\Tests;

require_once("autoload.php");

use PHPUnit\Framework\TestCase;
use CashMachine\NoteSet;
use CashMachine\Exceptions\InvalidNoteSetException;
use CashMachine\Exceptions\NoteUnavailableException;

/**
* NoteSetTest contains all unit tests for the NoteSet class
**
* @package  CashMachine\Tests
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class NoteSetTest extends TestCase
{
    /**
     * @covers CashMachine\NoteSet::__construct
     */
    public function test_should_accept_valid_populated_constructor()
    {
        $noteset = new NoteSet([1=>1, 2=>2]);
        $this->assertNotNull($noteset);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     */
    public function test_should_accept_empty_array_constructor()
    {
        $noteset = new NoteSet([]);
        $this->assertNotNull($noteset);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @expectedException \TypeError
     */
    public function test_should_throw_error_on_null_array_constructor()
    {
        $noteset = new NoteSet();
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\Exceptions\InvalidNoteSetException
     * @expectedException CashMachine\Exceptions\InvalidNoteSetException
     */
    public function test_should_throw_exception_on_non_positive_keys()
    {
        $noteset = new NoteSet([-10=>1]);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\Exceptions\InvalidNoteSetException
     * @expectedException CashMachine\Exceptions\InvalidNoteSetException
     */
    public function test_should_throw_exception_on_non_numic_keys()
    {
        $noteset = new NoteSet(['test'=>1]);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\Exceptions\InvalidNoteSetException
     * @expectedException CashMachine\Exceptions\InvalidNoteSetException
     */
    public function test_should_throw_exception_on_invalid_non_positive_values()
    {
        $noteset = new NoteSet([50=>-1]);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\Exceptions\InvalidNoteSetException
     * @expectedException CashMachine\Exceptions\InvalidNoteSetException
     */
    public function test_should_throw_exception_on_invalid_non_numeric_values()
    {
        $noteset = new NoteSet([50=>'test']);
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     */
    public function test_should_convert_to_array()
    {
        $values = [1 => 10, 5 => 3, 3 => 10];
        $noteset = new NoteSet($values);
        $this->assertEquals($noteset->toArray(), $values, "Should reflect array passed on constructor");
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     */
    public function test_should_implement_arrayaccess_get()
    {
        $noteset = new NoteSet([3 => 10, 50 => 3, 1 => 10]);
        $this->assertTrue($noteset[0]->quantity == 10 && $noteset[1]->quantity == 10 && $noteset[2]->quantity == 3, "Elements should be accessible by sorted index");
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     * @covers CashMachine\NoteSet::offsetSet
     */
    public function test_should_implement_arrayaccess_set()
    {
        $noteset = new NoteSet([1 => 10, 5 => 3, 3 => 10]);
        $noteset[0] = 99;
        $this->assertEquals($noteset->toArray()[1], 99, "Should be able to set note quantity by index");
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::count
     */
    public function test_should_implement_countable()
    {
        $this->assertEquals(sizeof(new NoteSet([])), 0, "Should count zero on empty set");
        $this->assertEquals(sizeof(new NoteSet([1 => 2, 5 => 1])), 2, "Should count properly on valid non-empty set");
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::Subtract
     * @covers CashMachine\NoteSet::offsetGet
     */
    public function test_should_subtract_from_other_noteset()
    {
        $notesetA = new NoteSet([1=> 1, 5 => 1]);
        $notesetB = new NoteSet([1=> 2, 5 => 2]);
        $notesetA->Subtract($notesetB);
        $this->assertTrue($notesetA[0]->quantity == -1 && $notesetA[0]->quantity == -1, "Should subtract elements");
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::Subtract
     * @covers CashMachine\Exceptions\NoteUnavailableException
     * @expectedException CashMachine\Exceptions\NoteUnavailableException
     */
    public function test_should_throw_error_on_subtracting_different_sets()
    {
        $notesetA = new NoteSet([1=> 1, 5 => 1]);
        $notesetB = new NoteSet([2=> 2, 3 => 2]);
        $notesetA->Subtract($notesetB, 'Non-existing bills');
    }


    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::offsetExists
     */
    public function test_should_verify_offset_exists()
    {
        $noteset = new NoteSet([1=> 1, 5 => 1]);
        $this->assertTrue(isset($noteset[1]),'Element is set');
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::offsetUnset
     * @covers CashMachine\NoteSet::offsetExists
     */
    public function test_should_not_remove_element_on_unset()
    {
        $noteset = new NoteSet([1=> 1, 5 => 1]);
        unset($noteset[1]);
        $this->assertTrue(isset($noteset[1]),'Element has been removed');
    }

    /**
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::__toString
     */
    public function test_should_print_pretty_string()
    {
        $noteset = new NoteSet([10=> 15, 50 => 33]);
        $output = $noteset.'';
        $this->assertTrue(strpos($output,'10')!==false && strpos($output,'15')!==false && strpos($output,'50')!==false && strpos($output,'33')!==false);
    }

}
