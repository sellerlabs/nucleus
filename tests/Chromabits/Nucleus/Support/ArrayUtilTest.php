<?php

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\ArrayUtils;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class ArrayUtilTest
 *
 * @package Tests\Chromabits\Nucleus\Support
 */
class ArrayUtilTest extends TestCase
{
    public function testConstructor()
    {
        $this->assertInstanceOf('Chromabits\Nucleus\Support\ArrayUtils', new ArrayUtils());
    }

    public function testFilterNull()
    {
        $input = [
            'key1' => 'content',
            'key2' => null,
            'otherkey' => null
        ];

        $output = [
            'key1' => 'content'
        ];

        $utils = new ArrayUtils();

        $this->assertEquals($output, $utils->filterNullValues($input));
    }

    public function testFilterNullWithAllowed()
    {
        $input = [
            'key1' => 'content',
            'key2' => null,
            'otherkey' => null,
            'otherkey2' => 'ishouldnotbehere'
        ];

        $output = [
            'key1' => 'content'
        ];

        $utils = new ArrayUtils();

        $this->assertEquals($output, $utils->filterNullValues($input, ['key1']));
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
            'first_name' => 'content'
        ];

        $utils = new ArrayUtils();

        $this->assertEquals($output, $utils->filterKeys($input, ['first_name']));
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

    /**
     * @expectedException \Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException
     */
    public function testExchangeWithInvalid()
    {
        $input = [10, 30, 20];

        $utils = new ArrayUtils();

        $utils->exchange($input, 1, 99);
    }
}
