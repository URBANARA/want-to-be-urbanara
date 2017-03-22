<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 15:57
 */
namespace UnitTests;

use CM\Exceptions\NoteUnavailableException;
use CM\Models\Money;
use CM\Services\CashMachine;
use PHPUnit\Framework\TestCase;

class CashMachineTest extends TestCase
{
    private $cashMachine;

    public function setUp()
    {
        $this->cashMachine = new CashMachine();
    }

    /**
     * @dataProvider getTestCashMachineReturnsCorrectNotesDataProvider
     */
    public function testCashMachineReturnsCorrectNotes($expected, $amount)
    {
        $withdraw = $this->cashMachine->withdraw(new Money($amount));
        $this->assertTrue($withdraw->isFilled());
        $this->assertEquals($expected, $withdraw->asArrayOfNoteValues());
    }

    public function getTestCashMachineReturnsCorrectNotesDataProvider()
    {
        return [
            'jump_one_note' => [
                [100, 20],
                120
            ],
            'all_notes_once' => [
                [100, 50, 20, 10],
                180
            ],
            'two_same_note' => [
                [100, 50, 20, 20],
                190
            ]
        ];
    }

    public function testCashMachineFullfillsOnlyExistingAmounts()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->cashMachine->withdraw(new Money(115));
    }

    public function testCashMachineReturnsOnlyAbsoluteAmounts()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->cashMachine->withdraw(new Money(-115));
    }
}
