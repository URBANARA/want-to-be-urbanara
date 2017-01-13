<?php

use PHPUnit\Framework\TestCase;
use Urbanara\GroupInterval;

/**
 * Class GroupByIntervalTest
 */
class GroupByIntervalTest extends TestCase
{
    public function testGroups()
    {
        $this->assertEquals([[-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]], GroupInterval::order(10, [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131]));
        $this->assertEquals([[-20], [1, 10], [14, 19, 20, 22], [93, 99], [117, 120], [131, 136]], GroupInterval::order(15, [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131]));
        $this->assertEquals([], GroupInterval::order(null, null));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgument()
    {
        $this->assertTrue(GroupInterval::order(15, [10, 1, 'A',  14, 99, 136, 19, 20, 117, 22, 93,  120, 131]));
    }
}
