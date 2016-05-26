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
    public function it_is_iterable()
    {
        static::assertInstanceOf(\Iterator::class, new DenominationCollection([1,2,3]));
    }

    /**
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
            [1, [54, '32', '1']],
            [0, [0, '32', '1']],
        ];
    }
}
