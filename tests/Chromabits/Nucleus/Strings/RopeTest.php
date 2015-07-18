<?php

namespace Tests\Chromabits\Nucleus\Strings;

use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\Strings\Rope;

/**
 * Class RopeTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Strings
 */
class RopeTest extends TestCase
{
    public function testCamel()
    {
        $this->assertEquals(
            'snakeCaseStuff',
            rope('snake_case_stuff')->toCamel()->toString()
        );
        $this->assertEquals(
            '今日は',
            rope('今日は')->toCamel()->toString()
        );
        $this->assertEquals(
            'studlyCaseStuff',
            rope('StudlyCaseStuff')->toCamel()->toString()
        );
    }

    public function testStudly()
    {
        $this->assertEquals(
            'SnakeCaseStuff',
            rope('snake_case_stuff')->toStudly()->toString()
        );
        $this->assertEquals(
            '今日は',
            rope('今日は')->toStudly()->toString()
        );
        $this->assertEquals(
            'CamelCaseStuff',
            rope('camelCaseStuff')->toStudly()->toString()
        );
    }

    public function testSnake()
    {
        $this->assertEquals(
            'camel_case_stuff',
            rope('camelCaseStuff')->toSnake()->toString()
        );
        $this->assertEquals(
            '今日は_wow_o_m_g',
            rope('今日はWowOMG')->toSnake()->toString()
        );
        $this->assertEquals(
            'studly_case_stuff',
            rope('StudlyCaseStuff')->toSnake()->toString()
        );
    }

    public function testCamelCache()
    {
        Rope::setCamelCache([
            md5('this_is_cached') => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            rope('this_is_cached')->toCamel()->toString()
        );
    }

    public function testStudlyCache()
    {
        Rope::setStudlyCache([
            md5('this_is_cached') => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            rope('this_is_cached')->toStudly()->toString()
        );
    }

    public function testSnakeCache()
    {
        Rope::setSnakeCache([
            md5('thisIsCached') . '_' => 'This is cached',
        ]);

        $this->assertEquals(
            'This is cached',
            rope('thisIsCached')->toSnake()->toString()
        );
    }
}
