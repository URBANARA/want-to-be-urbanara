<?php

use GroupByInterval\Grouper\Grouper;
use PHPUnit\Framework\TestCase;

class GroupByIntervalTest extends TestCase
{
    public function testWithRangeTen()
    {
        $range = 10;

        $number_set = [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93,  120, 131];

        $grouper = new Grouper($range, $number_set);

        $result = [[-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]];

        $this->assertEquals($result, $grouper->result());
    }

    public function testWithRangeFifteen()
    {
        $range = 15;

        $number_set = [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93, 120, 131];

        $grouper = new Grouper($range, $number_set);

        $result = [[-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120], [131], [136]];

        $this->assertEquals($result, $grouper->result());
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid argument: A
     */
    public function testInvalidArgument()
    {
        $range = 15;

        $number_set = [10, 1, 'A',  14, 99, 133, 19, 20, 117, 22, 93,  120, 131];

        $grouper = new Grouper($range, $number_set);

        $grouper->result();
    }

    /**
     * @expectedException TypeError
     */
    public function testNullRange()
    {
        $range = null;

        $number_set = [10, 1, 'A',  14, 99, 133, 19, 20, 117, 22, 93,  120, 131];

        new Grouper($range, $number_set);
    }
}