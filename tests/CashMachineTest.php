<?php


class CashMachineTest extends \PHPUnit\Framework\TestCase
{
    private $cashMachine;

    public function setUp()
    {
        $this->cashMachine = new CashMachine\CashMachine();
    }

    public function withdrawProvider()
    {
        return [
            [30.00, [20.00, 10.00]],
            [80.00, [50.00, 20.00, 10.00]],
            [260.00, [100.00, 100.00, 50.00, 10.00]],
            [140.00, [100.00, 20.00, 20.00]],
            [null, []],
        ];
    }

    /**
     * @test
     * @dataProvider withdrawProvider
     * @param $requested
     * @param $given
     */
    public function it_gives_notes($requested, $given)
    {
        $result = $this->cashMachine->withdraw($requested);
        $this->assertSame($given, $result);
    }

    /** @test */
    public function it_gives_error_when_note_unavailable()
    {
        $this->expectException(\CashMachine\Exception\NoteUnavailableException::class);
        $this->cashMachine->withdraw(125.00);
    }

    /** @test */
    public function it_gives_error_when_request_negative_value()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->cashMachine->withdraw(-130.00);
    }

    /** @test */
    public function it_gives_nothing_when_entry_null()
    {
        $result = $this->cashMachine->withdraw(null);
        $this->assertEmpty($result);
    }

    /** @test */
    public function it_gives_type_error_when_amount_is_not_numeric()
    {
        $this->expectException(TypeError::class);
        $this->cashMachine->withdraw('Abcdefg');
    }
}