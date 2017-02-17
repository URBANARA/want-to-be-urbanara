<?php
/**
 * @author Ondrej Führer <ondrej@fuhrer.cz>
 * @date 16.2.2017 13:55
 */

namespace Model;

/**
 * Class CashMachineTest
 * @package Model
 */
class CashMachineTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testGetNotesNegativeValue()
    {
        $cacheMachine = new CashMachine();
        $cacheMachine->withdraw(-1);
    }

    /**
     * @dataProvider validNotesDataProvider
     * @param float $amount
     * @param array $expectedResult
     */
    public function testGetNotes(float $amount = null, array $expectedResult)
    {
        $cacheMachine = new CashMachine();
        $result = $cacheMachine->withdraw($amount);

        $this->assertSame($expectedResult, $result);
    }

    /**
     * @return array[]
     */
    public function validNotesDataProvider()
    {
        return [
            '100 note' => [100.0, [100.0]],
            '50 note' => [50.0, [50.0]],
            '20 note' => [20.0, [20.0]],
            '10 note' => [10.0, [10.0]],
            'Zero amount' => [0.0, []],
            'Two different values returned' => [150.0, [100.0, 50.0]],
            'Two same values returned' => [40.0, [20.0, 20.0]],
            'Three values with repeating notes' => [140.0, [100.0, 20.0, 20.0]],
            'Three values without repeating notes' => [160.0, [100.0, 50.0, 10.0]],
            'NULL value' => [null, []],
        ];
    }

    /**
     * @dataProvider unavailableNotesDataProvider
     * @param float $amount
     *
     * @expectedException \Exception\NoteUnavailableException
     */
    public function testGetNotesUnavailableNotes(float $amount)
    {
        $cacheMachine = new CashMachine();
        $cacheMachine->withdraw($amount);
    }

    /**
     * @return array[]
     */
    public function unavailableNotesDataProvider()
    {
        return [
            'Low value without "cents"' => [5.0],
            'Value higher then lowest bill, without "cents"' => [31.0],
            'Value higher then lowest bill, with "cents"' => [15.5],
            'Very low value, only "cents"' => [0.01],
        ];
    }
}
