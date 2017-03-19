<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Usama\GroupByInterval;

class GroupByIntervalTest extends TestCase
{
    public function testSort()
    {
        $array = [3,2,1,5];
        $this->assertEquals([1, 2, 3, 5], GroupByInterval::qsort($array));
        $this->assertEquals([5, 3, 2, 1], GroupByInterval::qsort($array, false));
    }

    public function testSortNegative()
    {
        $array = [-5, -6, -15, -7];
        $this->assertEquals([-15, -7, -6, -5], GroupByInterval::qsort($array));
        $this->assertEquals([-5, -6, -7, -15], GroupByInterval::qsort($array, false));
    }

    public function testSortCombined()
    {
        $array = [-3, 5, 0, -8, 7];
        $this->assertEquals([-8, -3, 0, 5, 7], GroupByInterval::qsort($array));
        $this->assertEquals([7, 5, 0, -3, -8], GroupByInterval::qsort($array, false));
    }

    public function testSimpleGroup()
    {
        $expected = [[1,2,3,4],[5,6,7,8],[9]];
        $grouper = new GroupByInterval();
        $result = $grouper->group([1, 2, 3, 4, 5, 6, 7, 8, 9], 4);
        $this->assertEquals($expected, $result);
    }

    public function testTaskGroup()
    {
        $array = [10, 1, -20,  14, 99, 136, 19, 20, 117, 22, 93, 120, 131];
        $expected_10 = [[-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]];
        $expected_15 = [[-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120], [131], [136]];

        $grouper = new GroupByInterval();
        $this->assertTrue($grouper instanceof GroupByInterval);
        $this->assertEquals($expected_10, $grouper->group($array, 10));
        $this->assertEquals($expected_15, $grouper->group($array, 15));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testBadData()
    {
        $array = [10, 1, 'A', 14, 99, 133, 19, 20, 117, 22, 93, 120, 131];
        $grouper = new GroupByInterval();
        $grouper->group($array, 10);
    }

    public function testEmptyGroup()
    {
        $grouper = new GroupByInterval();
        $this->assertEquals([], $grouper->group([], null));
    }
}
