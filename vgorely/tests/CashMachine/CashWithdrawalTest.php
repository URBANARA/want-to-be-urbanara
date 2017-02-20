<?php

namespace Tests\Urbanara\CashMachine;

use Urbanara\CashMachine\CashMachine;
use Urbanara\CashMachine\CashWithdrawal;
use Urbanara\CashMachine\Exception\InvalidArgumentException;
use Urbanara\CashMachine\Exception\NoteUnavailableException;

class CashWithdrawalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CashMachine
     */
    private $cashMachine;

    protected function setUp()
    {
        parent::setUp();

        $this->cashMachine = new CashMachine([10, 20, 50, 100]);
    }

    public function testConstruct()
    {
        new CashWithdrawal($this->cashMachine);
    }

    public function testWithdrawOnInvalidAmount()
    {
        $cashWithdrawal = new CashWithdrawal($this->cashMachine);

        $this->expectException(InvalidArgumentException::class);
        $cashWithdrawal->withdraw(-130);
    }

    public function testWithdrawOnUnavailableAmount()
    {
        $cashWithdrawal = new CashWithdrawal($this->cashMachine);

        $this->expectException(NoteUnavailableException::class);
        $cashWithdrawal->withdraw(125);
    }

    /**
     * @return array
     */
    public function withdrawProvider()
    {
        return [
            [null, []],
            [0, []],
            [30, [20, 10]],
            [80, [50, 20, 10]],
        ];
    }

    /**
     * @param int $amount
     * @param array $expectedNotes
     *
     * @dataProvider withdrawProvider
     */
    public function testWithdraw($amount, array $expectedNotes)
    {
        $cashWithdrawal = new CashWithdrawal($this->cashMachine);
        $actualNotes = $cashWithdrawal->withdraw($amount);

        $this->assertEquals($expectedNotes, $actualNotes);
    }
}
