<?php

namespace Urbanara\Tests;

use PHPUnit\Framework\TestCase;
use \InvalidArgumentException;
use Urbanara\Solution;

/**
 * Class SolutionTest
 * @package Urbanara\Tests
 */
class SolutionTest extends TestCase
{
    /**
     * @return array
     */
    public function groupByIntervalDataProvider(): array
    {
        return [
            'Having "10" as range.' => [
                'input' => [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131],
                'range' => 10,
                'expected' => [
                    [-20], [1, 10], [14, 19, 20], [22], [93, 99], [117, 120], [131, 136]
                ],
            ],
            'Having "15" as range.' => [
                'input' => [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131],
                'range' => 15,
                'expected' => [
                    [-20], [1, 10, 14], [19, 20, 22], [93, 99], [117, 120], [131], [136]
                ],
            ],
            'Having duplicate data.' => [
                'input' => [10, 1, -20, -18, -10, -1, 14, 99, -5, 136, 19, 20, 117, 22, 93, 120, 131, 19],
                'range' => 10,
                'expected' => [
                    [-20, -18], [-10, -5, -1], [1, 10], [14, 19, 19, 20], [22], [93, 99], [117, 120], [131, 136]
                ],
            ],
            'Having "null" as range.' => [
                'input' => [10, 1, -20, 14, 99, 136, 19, 20, 117, 22, 93, 120, 131],
                'range' => null,
                'expected' => [
                ],
            ],
            'Having empty array as input.' => [
                'input' => [],
                'range' => 10,
                'expected' => [
                ],
            ],
            'Having empty array as input, and "Null" as range.' => [
                'input' => [],
                'range' => null,
                'expected' => [
                ],
            ],
        ];
    }
    
    /**
     * @param array      $input
     * @param int|null   $range
     * @param array      $expected
     *
     * @dataProvider groupByIntervalDataProvider
     */
    public function testShouldGroupByIntervalCorrectly(array $input, ?int $range, array $expected)
    {
        $solution = new Solution();
        $result = $solution->groupByRange($input, $range);
        $this->assertEquals($expected, $result);
    }

    /**
     * @return array
     */
    public function throwInvalidArgumentExceptionDataProvider(): array
    {
        return [
            'Having character in the set.' => [
                'input' => [10, 1, 'A', 14, 99, 133, 19, 20, 117, 22, 93, 120, 131],
                'range' => 10,
                'exception' => InvalidArgumentException::class,
            ],
            'Having boolean in the set.' => [
                'input' => [10, 1, true, 14, 99, 133, 19, 20, 117, 22, 93, 120, 131],
                'range' => 10,
                'exception' => InvalidArgumentException::class,
            ],
            'Having fraction in the set.' => [
                'input' => [10, 1, 5.3, 14, 99, 133, 19, 20, 117, 22, 93, 120, 131],
                'range' => 10,
                'exception' => InvalidArgumentException::class,
            ],
        ];
    }

    /**
     * @param array     $input
     * @param int|null  $range
     * @param string    $exception
     *
     * @dataProvider throwInvalidArgumentExceptionDataProvider
     */
    public function testShouldThrowInvalidArgumentException(array $input, ?int $range, string $exception)
    {
        $this->expectException($exception);
        $solution = new Solution();
        $solution->groupByRange($input, $range);
    }
}
