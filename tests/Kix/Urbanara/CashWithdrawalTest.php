<?php

namespace Kix\Urbanara\Tests;

use Kix\Urbanara\CashWithdrawal;
use Kix\Urbanara\NoteUnavailableException;

class CashWithdrawalTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_throws_for_negative_amounts()
    {
        $this->expectException(\InvalidArgumentException::class);

        new CashWithdrawal(-100);
    }

    /**
     * @test
     */
    public function it_throws_when_amount_cannot_be_exchanged()
    {
        $this->expectException(NoteUnavailableException::class);

        new CashWithdrawal(195);
    }

    /**
     * @test
     * @dataProvider provideExampleWithdrawals
     */
    public function it_calculates_correct_amounts($requestedAmount, $expectedBills, $denominations = null)
    {
        if ($denominations) {
            $withdrawal = new CashWithdrawal($requestedAmount, $denominations);
        } else {
            $withdrawal = new CashWithdrawal($requestedAmount);
        }

        $actualBills = $withdrawal->execute();

        static::assertEquals($expectedBills, $actualBills);
    }

    public function provideExampleWithdrawals()
    {
        return [
            [30.00, [20.00, 10.00]],
            [80.00, [50.00, 20.00, 10.00]],
            [120.00, [100.00, 20.00]],
            [100, [100.00]],
            [200, [100.00, 100.00]],
            [50.00, [50.00]],
            [31.20, [30.00, 1.00, 0.1, 0.1], [30.00, 1.00, 0.1]],
            [null, []]
        ];
    }

    /**
     * @test
     * @dataProvider provideInvalidDenominationSets
     */
    public function it_throws_for_invalid_denominations($denominations)
    {
        $this->expectException(\InvalidArgumentException::class);

        new CashWithdrawal(100, $denominations);
    }

    public function provideInvalidDenominationSets()
    {
        return [
            [['blah', 'test', 100]],
            [['0xff']],
            [[]]
        ];
    }

}
