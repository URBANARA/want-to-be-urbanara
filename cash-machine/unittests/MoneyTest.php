<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 22/03/17
 * Time: 18:37
 */
namespace UnitTests;

use CM\Models\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMoneyAcceptsOnlyNumber()
    {
        $this->expectException(\InvalidArgumentException::class);
        $money = new Money('a');
    }

    public function testMoneyReturnsCorrectNegative()
    {
        $money = new Money(-10);
        $this->assertTrue($money->isNegative());
    }

    public function testMoneyDividesCorrectly()
    {
        $money = new Money(10);
        $this->assertEquals(5, $money->divideBy(2));
    }

    public function testSubtractMoney()
    {
        $money = new Money(10);
        $this->assertEquals(new Money(8), $money->subtract(new Money(2)));
    }
}
