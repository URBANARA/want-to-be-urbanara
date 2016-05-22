<?php
/**
 * User: Oleksii Polishchuk
 * Date: 21.05.2016
 */

namespace CashMachine\Tests\Service;


use CashMachine\Service\Processor;

class ProcessorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Processor
     */
    protected $processor;

    public function setUp()
    {
        $this->processor = new Processor();

        parent::setUp();
    }

    public function testWithdrawEmptyAmount()
    {
        $this->expectException('InvalidArgumentException');
        $this->processor->withdraw(0);

        $this->expectException('InvalidArgumentException');
        $this->processor->withdraw('');

        $this->expectException('InvalidArgumentException');
        $this->processor->withdraw(null);
    }

    public function testWithdrawThirty()
    {
        $withdrawResult = $this->processor->withdraw(30);
        $this->assertEquals([20, 10], $withdrawResult);
    }

    public function testWithdrawEighty()
    {
        $withdrawResult = $this->processor->withdraw(80);
        $this->assertEquals([50, 20, 10], $withdrawResult);
    }

    public function testWithdrawTwoHundred()
    {
        $withdrawResult = $this->processor->withdraw(200);
        $this->assertEquals([100, 100], $withdrawResult);
    }

    public function testWithdrawTwoHundredSixty()
    {
        $withdrawResult = $this->processor->withdraw(260);
        $this->assertEquals([100, 100, 50, 10], $withdrawResult);
    }

    public function testWithdrawOneHundredTwentyFive()
    {
        $this->expectException('CashMachine\Exception\NoteUnavailableException');

        $this->processor->withdraw(125);
    }

    public function testWithdrawThreeHundredTwentyOne()
    {
        $this->expectException('CashMachine\Exception\NoteUnavailableException');

        $this->processor->withdraw(321);
    }

    public function testWithdrawFifteen()
    {
        $this->expectException('CashMachine\Exception\NoteUnavailableException');

        $this->processor->withdraw(15);
    }

    public function testWithdrawMinusOneHundredThirty()
    {
        $this->expectException('InvalidArgumentException');
        
        $this->processor->withdraw(-130);
    }

}
