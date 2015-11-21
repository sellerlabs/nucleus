<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Strings;

use Chromabits\Nucleus\Strings\Rope;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class RopeTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Strings
 */
class RopeTest extends TestCase
{
    public function testCamel()
    {
        $this->assertEqualsMatrix([
            ['snakeCaseWoo', (string) Rope::of('snake_case_woo')->toCamel()],
            ['今日は', Rope::of('今日は')->toCamel()],
            ['studlyCaseStuff', Rope::of('StudlyCaseStuff')->toCamel()],
        ]);
    }

    public function testStudly()
    {
        $this->assertEqualsMatrix([
            [
                'SnakeCaseStuff',
                Rope::of('snake_case_stuff')->toStudly()->toString()
            ],
            [
                '今日は',
                Rope::of('今日は')->toStudly()->toString()
            ],
            [
                'CamelCaseStuff',
                Rope::of('camelCaseStuff')->toStudly()->toString()
            ],
            [
                'ImageUri',
                Rope::of('imageUri')->toStudly()->toString()
            ],
            [
                'ImageUri',
                Rope::of('image_uri')->toStudly()->toString()
            ],
        ]);
    }

    public function testSnake()
    {
        $this->assertEqualsMatrix([
            [
                'camel_case_stuff',
                Rope::of('camelCaseStuff')->toSnake()->toString()
            ],
            [
                '今日は_wow_o_m_g',
                Rope::of('今日はWowOMG')->toSnake()->toString()
            ],
            [
                'studly_case_stuff',
                Rope::of('StudlyCaseStuff')->toSnake()->toString()
            ],
        ]);
    }

    public function testCamelCache()
    {
        Rope::setCamelCache([
            md5('this_is_cached') => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            Rope::of('this_is_cached')->toCamel()->toString()
        );
    }

    public function testStudlyCache()
    {
        Rope::setStudlyCache([
            md5('this_is_cached') => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            Rope::of('this_is_cached')->toStudly()->toString()
        );
    }

    public function testSnakeCache()
    {
        Rope::setSnakeCache([
            md5('thisIsCached') . '_' => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            Rope::of('thisIsCached')->toSnake()->toString()
        );
    }

    public function testGetEncoding()
    {
        $this->assertEquals(
            Rope::ENCODING_UTF8,
            Rope::of('hello world', Rope::ENCODING_UTF8)->getEncoding()
        );
    }

    public function testLowerFirst()
    {
        $this->assertEqualsMatrix([
            ['omg', Rope::of('omg')->lowerFirst()->toString()],
            ['lower今日は', Rope::of('Lower今日は')->lowerFirst()->toString()],
        ]);
    }

    public function testUpperFirst()
    {
        $this->assertEqualsMatrix([
            ['Omg', Rope::of('omg')->upperFirst()->toString()],
            ['Lower今日は', Rope::of('Lower今日は')->upperFirst()->toString()],
        ]);
    }

    public function testIsLower()
    {
        $this->assertEqualsMatrix([
            [true, Rope::of('omg')->isLower()],
            [false, Rope::of('Lower今日は')->isLower()],
        ]);
    }

    public function testUpperWords()
    {
        $this->assertEqualsMatrix([
            ['Omg Words', Rope::of('omg words')->upperWords()->toString()],
            ['Lower 今日は', Rope::of('Lower 今日は')->upperWords()->toString()],
        ]);
    }
}
