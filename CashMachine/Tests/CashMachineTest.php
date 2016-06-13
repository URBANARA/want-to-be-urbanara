<?php
/**
 * Created by PhpStorm.
 * User: Amirali
 * Date: 6/13/2016
 * Time: 1:03 PM
 */

namespace App\Tests;


use AppCode\Client\CashMachine;
use AppCode\InputOutput\CashMachineRequest;
use AppCode\Exception\NoteUnavailableException;

class CashMachineTest extends \PHPUnit_Framework_TestCase
{
    private $cashMachine;

    public function __construct()
    {
        $this->cashMachine = new CashMachine();
    }

    public function __destruct()
    {
        unset($this->cashMachine);
    }

    // Provided test 1
    public function testAmount30()
    {
        $request = new CashMachineRequest(30);
        $result = $this->cashMachine->WithdrawCash($request);

        $this->assertInstanceOf("AppCode\Note\TwentyNote", $result[0], "Expected a 20 value note");
        $this->assertInstanceOf("AppCode\Note\TenNote", $result[1], "Expected a 10 value note");
    }

    // Provided test 2
    public function testAmount80()
    {
        $request = new CashMachineRequest(80);
        $result = $this->cashMachine->WithdrawCash($request);

        $this->assertInstanceOf("AppCode\Note\FiftyNote", $result[0], "Expected a 50 value note");
        $this->assertInstanceOf("AppCode\Note\TwentyNote", $result[1], "Expected a 20 value note");
        $this->assertInstanceOf("AppCode\Note\TenNote", $result[2], "Expected a 10 value note");
    }

    // Provided test 3
    public function testAmount125()
    {
        $this->setExpectedException(NoteUnavailableException::class);
        $request = new CashMachineRequest(125);
        $this->cashMachine->WithdrawCash($request);
    }

    // Provided test 4
    public function testAmountMinus130()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $request = new CashMachineRequest(-130);
        $this->cashMachine->WithdrawCash($request);
    }

    // Provided test 5
    public function testAmountNULL()
    {
        $request = new CashMachineRequest(NULL);
        $result = $this->cashMachine->WithdrawCash($request);

        $this->assertEmpty($result, "Expected an empty set");
    }
}
