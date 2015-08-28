<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ArrTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class ArrTest extends TestCase
{
    public function testOnly()
    {
        $this->assertEqualsMatrix([
            [[], Arr::only([1, 2, 3])],
            [[1], Arr::only([1, 2, 3], [0])],
            [[0 => 1, 2 => 3], Arr::only([1, 2, 3], [0, 2])],
        ]);
    }

    public function testExcept()
    {
        $this->assertEqualsMatrix([
            [[], Arr::except([1, 2, 3], [0, 1, 2])],
            [[1 => 2], Arr::except([1, 2, 3], [0, 2])],
            [[0 => 1, 2 => 3], Arr::except([1, 2, 3], [1])],
        ]);
    }

    public function testWalk()
    {
        $input = [
            'test' => 'omg',
            'yes' => [
                'works?' => ['perhaps'],
                'one' => 'day',
            ],
        ];

        Arr::walk($input, function ($key, $value, &$array, $path) {
            $array[$key] = 'huh';
        }, true, '', true);

        $output = [
            'test' => 'huh',
            'yes' => [
                'works?' => ['huh'],
                'one' => 'huh',
            ],
        ];

        $this->assertEquals($output, $input);
    }

    public function testWalkWithIngnoreLeaves()
    {
        $input = [
            'test' => 'omg',
            'yes' => [
                'works?' => ['perhaps'],
                'one' => 'day',
            ],
        ];

        Arr::walk($input, function ($key, $value, &$array, $path) {
            $array[$key] = 'huh';
        }, true, '', false);

        $output = [
            'test' => 'huh',
            'yes' => [
                'works?' => 'huh',
                'one' => 'huh',
            ],
        ];

        $this->assertEquals($output, $input);
    }

    public function testFilterNullWithAllowed()
    {
        $input = [
            'key1' => 'content',
            'key2' => null,
            'otherkey' => null,
            'otherkey2' => 'ishouldnotbehere',
        ];

        $output = [
            'key1' => 'content',
        ];

        $this->assertEquals(
            $output,
            Arr::filterNullValues($input, ['key1'])
        );
    }

    public function testExchange()
    {
        $input = [10, 30, 20];

        Arr::exchange($input, 1, 2);

        $this->assertEquals(10, $input[0]);
        $this->assertEquals(20, $input[1]);
        $this->assertEquals(30, $input[2]);

        Arr::exchange($input, 0, 1);
        Arr::exchange($input, 0, 2);
    }

    public function testExchangeWithInvalid()
    {
        $input = [10, 30, 20];

        $this->setExpectedException(IndexOutOfBoundsException::class);

        Arr::exchange($input, 1, 99);
    }
}
