<?php

namespace Kix\Urbanara\Tests\CashWithdrawal;

use Kix\Urbanara\CashWithdrawal\DenominationCollection;

/**
 * Class DenominationCollectionTest
 */
class DenominationCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_throws_for_empty_collections()
    {
        $this->expectException(\InvalidArgumentException::class);
        new DenominationCollection([]);
    }

    /**
     * @test
     */
    public function it_throws_for_invalid_denominations()
    {
        $this->expectException(\InvalidArgumentException::class);
        new DenominationCollection(['test', '12312']);
    }

    /**
     * @test
     */
    public function it_throws_for_zero_denominations()
    {
        $this->expectException(\InvalidArgumentException::class);
        new DenominationCollection([0, -10]);
    }

    /**
     * @test
     */
    public function it_is_iterable()
    {
        static::assertInstanceOf(\Iterator::class, new DenominationCollection([1,2,3]));
    }

    /**
     * @test
     */
    public function it_supports_floats()
    {
        $coll = new DenominationCollection([0.10, 0.30]);

        static::assertEquals(10, $coll->min());
        static::assertContains(10, $coll);
        static::assertContains(30, $coll);
    }

    /**
     * @test
     * @dataProvider provideMinimals
     */
    public function it_returns_minimal_element($expected, $source)
    {
        $collection = new DenominationCollection($source);

        static::assertEquals($expected, $collection->min());
    }

    public function provideMinimals()
    {
        return [
            [100, [54, '32', '1']],
            [1000, ['32', 10]],
        ];
    }
}
