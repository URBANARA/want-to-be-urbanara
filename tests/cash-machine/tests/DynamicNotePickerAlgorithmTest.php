<?php

namespace CashMachine\Tests;

require_once("autoload.php");

use PHPUnit\Framework\TestCase;
use CashMachine\DynamicNotePickerAlgorithm;
use CashMachine\NoteSet;
use CashMachine\Exceptions\InvalidNoteSetException;
use CashMachine\Exceptions\InvalidArgumentException;
use CashMachine\Exceptions\NoteUnavailableException;
use CashMachine\Exceptions\UndefinedNoteSetException;

/**
* DynamicNotePickerAlgorithmTest contains all unit tests for the DynamicNotePickerAlgorithm class
**
* @package  CashMachine\Tests
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class DynamicNotePickerAlgorithmTest extends TestCase
{

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     * @covers CashMachine\NoteSet::count
     */
    public function test_should_pass_testcase_01_provided()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([10=>100, 20=>100, 50=>100, 100=>100]);
        $notesWithdraw = $alg->PickUpNotes(30, $notesAvailable)->toArray();
        $this->assertTrue($notesWithdraw[10] == 1 && $notesWithdraw[20] == 1, "withdraw of 30 should give 1 of 10 and 1 of 20");
        $this->assertTrue(sizeof($notesWithdraw) == 2, "and there are only two notes being used");
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     * @covers CashMachine\NoteSet::count
     */
    public function test_should_pass_testcase_02_provided()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([10=>100, 20=>100, 50=>100, 100=>100]);
        $notesWithdraw = $alg->PickUpNotes(80, $notesAvailable)->toArray();
        $this->assertTrue($notesWithdraw[10] == 1 && $notesWithdraw[20] == 1 && $notesWithdraw[50] == 1, "withdraw of 80 should give 1 of 10 and 1 of 20 and 1 of 50");
        $this->assertTrue(sizeof($notesWithdraw) == 3, "and there are only three notes being used");
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     * @covers CashMachine\Exceptions\NoteUnavailableException
     * @expectedException CashMachine\Exceptions\NoteUnavailableException
     */
    public function test_should_pass_testcase_03_provided()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([10=>100, 20=>100, 50=>100, 100=>100]);
        $alg->PickUpNotes(125, $notesAvailable);
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\Exceptions\InvalidArgumentException
     * @expectedException CashMachine\Exceptions\InvalidArgumentException
     */
    public function test_should_pass_testcase_04_provided()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([10=>100, 20=>100, 50=>100, 100=>100]);
        $alg->PickUpNotes(-130, $notesAvailable);
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     */
    public function test_should_pass_testcase_05_provided()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([10=>100, 20=>100, 50=>100, 100=>100]);
        $notesWithdraw = $alg->PickUpNotes(null, $notesAvailable);
        $this->assertEquals(sizeof($notesWithdraw), 0, "Should return NULL while passing NULL as amount");
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\Exceptions\UndefinedNoteSetException
     * @expectedException CashMachine\Exceptions\UndefinedNoteSetException
     */
    public function test_should_prevent_running_on_undefined_available_noteset()
    {
        $alg = new DynamicNotePickerAlgorithm();
        $alg->PickUpNotes(125, null);
    }

    /**
     * @covers CashMachine\DynamicNotePickerAlgorithm::PickUpNotes
     * @covers CashMachine\NoteSet::__construct
     * @covers CashMachine\NoteSet::toArray
     * @covers CashMachine\NoteSet::offsetGet
     * @covers CashMachine\NoteSet::count
     */
    public function test_should_pass_test_set_provided_by_csbreakdown()
    {
        // at https://www.youtube.com/watch?v=rdI94aW6IWw
        $alg = new DynamicNotePickerAlgorithm();
        $notesAvailable = new NoteSet([1=>100, 5=>100, 12=>100, 25=>100]);
        $notesWithdraw = $alg->PickUpNotes(16, $notesAvailable)->toArray();
        $this->assertTrue($notesWithdraw[1] == 1 && $notesWithdraw[5] == 3, "withdraw of 16 should give 1 of 1 and 3 of 5");
        $this->assertTrue(sizeof($notesWithdraw) == 2, "and there are only two notes being used");
    }
}
