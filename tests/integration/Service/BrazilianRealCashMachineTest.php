<?php

namespace Urbanara\CashMachine\IntegrationTests\Service;

use PHPUnit_Framework_TestCase;
use Urbanara\CashMachine\Exception\NoteUnavailableException;
use Urbanara\CashMachine\Factory\BrazilianRealNoteFactory;
use Urbanara\CashMachine\Factory\CurrencyFactory;
use Urbanara\CashMachine\Service\CashMachine;
use Urbanara\CashMachine\Service\LowestAmountPossibleCalculator;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Service
 */
class BrazilianRealCashMachineTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Urbanara\CashMachine\Service\CashMachine
     */
    private $cashMachine;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->cashMachine = new CashMachine(
            new LowestAmountPossibleCalculator(),
            new BrazilianRealNoteFactory(
                new CurrencyFactory()
            )
        );
    }

    public function testWhenReturnAnEmptySet()
    {
        $this->assertEquals([], $this->cashMachine->withdraw(null));
    }

    /**
     * @throws \Urbanara\CashMachine\Exception\NoteUnavailableException
     */
    public function testUnableToWithdraw()
    {
        $this->expectException(NoteUnavailableException::class);
        $this->expectExceptionMessage('Unable to withdraw');

        $this->cashMachine->withdraw(125.00);
    }

    /**
     * @dataProvider getDataProviderToSuccessfullyWithdraw
     *
     * @param float $amount
     * @param array $expectedResult
     *
     * @throws \Urbanara\CashMachine\Exception\NoteUnavailableException
     */
    public function testTheSuccessWhenWithdrawing($amount, array $expectedResult)
    {
        $result = $this->cashMachine->withdraw($amount);

        $this->assertEquals($amount, array_sum($result), 'Result sum must be equals to amount');

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function getDataProviderToSuccessfullyWithdraw()
    {
        return [
            'Requested 30.00 must deliver 20.00 and 10.00' => [
                30.00,
                [
                    20.00,
                    10.00,
                ],
            ],
            'Requested 80.00 must deliver 50.00, 20.00 and 10.00' => [
                80.00,
                [
                    50.00,
                    20.00,
                    10.00,
                ],
            ],
            'Requested 50.00 must deliver 50.00' => [
                50.00,
                [
                    50.00,
                ],
            ],
        ];
    }
}
