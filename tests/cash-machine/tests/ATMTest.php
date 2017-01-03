<?php

namespace CashMachine\Tests;

require_once("autoload.php");
use PHPUnit\Framework\TestCase;
use CashMachine\ATM as ATM;
use CashMachine\NoteSet;

/**
* ATMTest contains all unit tests for the ATM class
**
* @package  CashMachine\Tests
* @author   Walter Carrer Neto <carrer@gmail.com>
* @version  1.0
* @access   public
*/
class ATMTest extends TestCase
{

    /**
     * @covers CashMachine\ATM::__construct
     * @covers CashMachine\ATM::RefilNotes
     * @covers CashMachine\ATM::GetBalance
     */
    public function test_should_provide_balance()
    {
        $atm = new ATM();
        $atm->RefilNotes(new NoteSet([25 => 100, 50 => 10]));
        $notes = $atm->GetBalance()->toArray();
        $this->assertTrue($notes[25] == 100 && $notes[50] == 10, "Should inform balance properly");
    }

    /**
     * @covers CashMachine\ATM::__construct
     * @covers CashMachine\Exceptions\UndefinedNoteSetException
     * @expectedException CashMachine\Exceptions\UndefinedNoteSetException
     */
    public function test_should_not_withdraw_without_initialized_noteset()
    {
        $atm = new ATM();
        $atm->PerformWithdraw(10);
    }

    /**
     * @covers CashMachine\ATM::__construct
     * @covers CashMachine\Exceptions\NotNotePickerAlgorithmException
     * @expectedException CashMachine\Exceptions\NotNotePickerAlgorithmException
     */
    public function test_should_validate_inotepickeralgorithm_on_construct()
    {
        $atm = new ATM(ATM::class);
    }


    /**
     * @covers CashMachine\ATM::__construct
     * @covers CashMachine\ATM::RefilNotes
     * @covers CashMachine\ATM::PerformWithDraw
     * @covers CashMachine\ATM::GetBalance
     */
    public function test_should_reduce_balance_on_withdraw()
    {
        $atm = new ATM();
        $atm->RefilNotes(new NoteSet([25 => 100, 50 => 10]));
        $atm->PerformWithDraw(100);
        $notes = $atm->GetBalance()->toArray();
        $this->assertTrue($notes[25] == 100 && $notes[50] == 8, "Should take out two '50' bills");
    }

    /**
     * @covers CashMachine\ATM::__construct
     * @covers CashMachine\ATM::RefilNotes
     * @covers CashMachine\ATM::PerformWithDraw
     */
    public function test_should_withdraw_money()
    {
        $atm = new ATM();
        $atm->RefilNotes(new NoteSet([1 => 100]));
        $notes = $atm->PerformWithDraw(13);
        $this->assertEquals($notes->toArray(), [1=>13], "Should take out thirteen '1' bills");
    }
}
