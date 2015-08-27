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
use Chromabits\Nucleus\Support\ArrayUtils;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class ArrayUtilTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class ArrayUtilTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf(ArrayUtils::class, new ArrayUtils());
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

        $utils = new ArrayUtils();

        $this->assertEquals(
            $output,
            $utils->filterNullValues($input, ['key1'])
        );
    }

    public function testCallSetters()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $mock = Mockery::mock();
        $utils = new ArrayUtils();

        $mock->shouldReceive('setFirstName');
        $mock->shouldReceive('setLastName');

        $utils->callSetters($mock, $input);

        $mock->shouldHaveReceived('setFirstName', ['content']);
        $mock->shouldHaveReceived('setLastName', [null]);
    }

    public function testCallSettersWithAllowed()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $mock = Mockery::mock();
        $utils = new ArrayUtils();

        $mock->shouldReceive('setFirstName');
        $mock->shouldReceive('setLastName');

        $utils->callSetters($mock, $input, ['first_name']);

        $mock->shouldHaveReceived('setFirstName', ['content']);
        $mock->shouldNotHaveReceived('setLastName');
    }

    public function testFilterKeys()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $output = [
            'first_name' => 'content',
        ];

        $utils = new ArrayUtils();

        $this->assertEquals(
            $output,
            $utils->filterKeys($input, ['first_name'])
        );
        $this->assertEquals($input, $utils->filterKeys($input, []));
        $this->assertEquals($input, $utils->filterKeys($input, null));
        $this->assertEquals($input, $utils->filterKeys($input));
    }

    public function testExchange()
    {
        $input = [10, 30, 20];

        $utils = new ArrayUtils();

        $utils->exchange($input, 1, 2);

        $this->assertEquals(10, $input[0]);
        $this->assertEquals(20, $input[1]);
        $this->assertEquals(30, $input[2]);

        $utils->exchange($input, 0, 1);
        $utils->exchange($input, 0, 2);
    }

    public function testExchangeWithInvalid()
    {
        $input = [10, 30, 20];

        $utils = new ArrayUtils();

        $this->setExpectedException(IndexOutOfBoundsException::class);

        $utils->exchange($input, 1, 99);
    }
}
