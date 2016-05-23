<?php

namespace Kisphp\Testing;

use Kisphp\CashFactory;

class CardTest extends \PHPUnit_Framework_TestCase
{
    public function test_input_one()
    {
        $cashMachine = CashFactory::createCashMachine();

        $output = $cashMachine->withdraw(30);

        $this->assertSame([
            '20.00',
            '10.00',
        ], array_keys($output));
    }

    public function test_input_two()
    {
        $cashMachine = CashFactory::createCashMachine();

        $output = $cashMachine->withdraw(80);

        $this->assertSame([
            '50.00',
            '20.00',
            '10.00',
        ], array_keys($output));
    }

    /**
     * @expectedException \Kisphp\Exceptions\NoteUnavailableException
     */
    public function test_unavailable_request()
    {
        $cashMachine = CashFactory::createCashMachine();

        $cashMachine->withdraw(125.00);
    }

    /**
     * @expectedException \Kisphp\Exceptions\InvalidArgumentException
     */
    public function test_invalid_request()
    {
        $cashMachine = CashFactory::createCashMachine();

        $cashMachine->withdraw(-130.00);
    }

    public function test_null_requests()
    {
        $cashMachine = CashFactory::createCashMachine();

        $outputNull = $cashMachine->withdraw(null);
        $this->assertNull($outputNull);
    }

    /**
     * @expectedException \Kisphp\Exceptions\InvalidArgumentException
     */
    public function test_zero_request()
    {
        $cashMachine = CashFactory::createCashMachine();

        $output = $cashMachine->withdraw(0);

        $this->assertNull($output);
    }

    /**
     * @dataProvider doublesProvider
     *
     * @param $amount
     * @param array $expected
     * @throws \Kisphp\Exceptions\InvalidArgumentException
     * @throws \Kisphp\Exceptions\NoteUnavailableException
     */
    public function test_doubles($amount, array $expected)
    {
        $cashMachine = CashFactory::createCashMachine();

        $output = $cashMachine->withdraw($amount);

        $this->assertSame($expected, array_keys($output));
    }

    /**
     * @return array
     */
    public function doublesProvider()
    {
        return [
            [1000030, ['100.00', '20.00', '10.00']],
            [100000, ['100.00']],
            [940, ['100.00', '20.00']],
            [90, ['50.00', '20.00']],
            [60, ['50.00', '10.00']],
            [40, ['20.00']],
        ];
    }
}