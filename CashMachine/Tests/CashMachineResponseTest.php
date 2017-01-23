<?php
/**
 * Created by PhpStorm.
 * User: Amirali
 * Date: 6/13/2016
 * Time: 12:39 PM
 */

namespace App\Tests;


use AppCode\InputOutput\CashMachineResponse;
use AppCode\Note\FiftyNote;
use AppCode\Note\HundredNote;
use AppCode\Note\TenNote;
use AppCode\Note\TwentyNote;

class CashMachineResponseTest extends \PHPUnit_Framework_TestCase
{
    private $responseInstance;

    function setUp()
    {
        $this->responseInstance = new CashMachineResponse(150);
    }

    function tearDown()
    {
        unset($this->responseInstance);
    }

    public function testTotalConsumption()
    {
        $this->responseInstance->AddNote(new TwentyNote());
        $this->responseInstance->AddNote(new TwentyNote());
        $this->responseInstance->AddNote(new TenNote());
        $this->responseInstance->AddNote(new FiftyNote());
        $this->responseInstance->AddNote(new FiftyNote());

        $this->assertTrue($this->responseInstance->isAmountConsumed());
    }

    public function testPartialConsumption()
    {
        $this->responseInstance->AddNote(new HundredNote());

        $this->assertFalse($this->responseInstance->isAmountConsumed());
    }

    public function testNotesAccuracy()
    {
        $this->responseInstance->AddNote(new HundredNote());
        $this->responseInstance->AddNote(new TwentyNote());

        $notes = $this->responseInstance->GetNotes();

        $this->assertInstanceOf("AppCode\Note\HundredNote", $notes[0], "Expected a hundred value note");
        $this->assertInstanceOf("AppCode\Note\TwentyNote", $notes[1], "Expected a twenty value note");
    }

    public function testAmountPartialConsumedAccuracy()
    {
        $this->responseInstance->AddNote(new HundredNote());
        $this->responseInstance->AddNote(new TwentyNote());

        $this->assertEquals(30, $this->responseInstance->GetAmount());
    }

    public function testAmountConsumedAccuracy()
    {
        $this->responseInstance->AddNote(new HundredNote());
        $this->responseInstance->AddNote(new FiftyNote());

        $this->assertEquals(0, $this->responseInstance->GetAmount());
    }
}
