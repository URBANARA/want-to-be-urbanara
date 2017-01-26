<?php

namespace Urbanara\CashMachine\UnitTests\Service;

use InvalidArgumentException;
use PHPUnit_Framework_TestCase;
use Urbanara\CashMachine\Service\LowestAmountPossibleCalculator;

/**
 * @author Alexandre Rodrigues Xavier <alexandre.rodrigues.xv@gmail.com>
 *
 * @package Urbanara\CashMachine\Service
 */
class LowestAmountPossibleCalculatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Urbanara\CashMachine\Service\LowestAmountPossibleCalculator
     */
    private $lowestAmountPossibleCalculator;

    /**
     * @var array
     */
    private $possibilities = [
        100.00,
        50.00,
        20.00,
        10.00,
    ];

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     */
    public function setUp()
    {
        $this->lowestAmountPossibleCalculator = new LowestAmountPossibleCalculator();
    }

    /**
     * Test must throw an invalid argument exception
     */
    public function testPassAnInvalidArgument()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Amount must be a positive number');

        $this->lowestAmountPossibleCalculator->findLowestDistribution(
            -130.00,
            $this->possibilities
        );
    }

    /**
     * Test the failure when finding lowest distribution
     */
    public function testTheFailureWhenFindingLowestDistribution()
    {
        $this->assertEquals(
            [],
            $this->lowestAmountPossibleCalculator->findLowestDistribution(
                125.00,
                $this->possibilities
            )
        );
        $this->assertEquals(
            [],
            $this->lowestAmountPossibleCalculator->findLowestDistribution(
                5.00,
                $this->possibilities
            )
        );
    }

    /**
     * @dataProvider getDataProviderToSucceedOnFindingLowestDistribution
     *
     * @param float $amount
     * @param array $expectedResult
     */
    public function testTheSuccessWhenFindingLowestDistribution($amount, array $expectedResult)
    {
        $result = $this->lowestAmountPossibleCalculator->findLowestDistribution(
            $amount,
            $this->possibilities
        );

        $this->assertEquals($amount, array_sum($result), 'Result sum must be equals to amount');

        $this->assertEquals($expectedResult, $result);
    }

    /**
     * @return array
     */
    public function getDataProviderToSucceedOnFindingLowestDistribution()
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
            'Requested 160.00 must deliver 100.00, 50.00 and 10.00' => [
                160.00,
                [
                    100.00,
                    50.00,
                    10.00,
                ],
            ],
            'Requested 200.00 must deliver 100.00 and 100.00' => [
                200.00,
                [
                    100.00,
                    100.00,
                ],
            ],
        ];
    }
}
