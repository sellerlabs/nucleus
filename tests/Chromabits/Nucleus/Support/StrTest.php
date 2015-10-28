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

use Chromabits\Nucleus\Support\Str;
use Chromabits\Nucleus\Testing\TestCase;
use PHPUnit_Extension_FunctionMocker as FunctionMocker;

/**
 * Class StrTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class StrTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $php;

    public function testCamel()
    {
        $this->assertEquals('snakeCaseStuff', Str::camel('snake_case_stuff'));
        $this->assertEquals('studlyCaseStuff', Str::camel('StudlyCaseStuff'));
    }

    public function testStudly()
    {
        $this->assertEquals('SnakeCaseStuff', Str::studly('snake_case_stuff'));
        $this->assertEquals('CamelCaseStuff', Str::studly('camelCaseStuff'));
    }

    public function testSnake()
    {
        $this->assertEquals('camel_case_stuff', Str::snake('camelCaseStuff'));
        $this->assertEquals(
            'studly_case_stuff',
            Str::snake('StudlyCaseStuff')
        );
    }

    public function testQuickRandom()
    {
        $someInteger = mt_rand(1, 100);

        $this->assertEquals(
            $someInteger,
            strlen(Str::quickRandom($someInteger))
        );
        $this->assertInternalType('string', Str::quickRandom());
        $this->assertEquals(16, strlen(Str::quickRandom()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testRandom()
    {
        $this->assertEquals(16, strlen(Str::random()));

        $someInteger = mt_rand(1, 100);
        $this->assertEquals($someInteger, strlen(Str::random($someInteger)));
        $this->assertInternalType('string', Str::random());
    }

    /**
     * @runInSeparateProcess
     * @expectedException \RuntimeException
     */
    public function testRandomWithMissingFunction()
    {
        $this->php = FunctionMocker::start($this, 'Chromabits\Nucleus\Support')
             ->mockFunction('function_exists')
             ->mockFunction('openssl_random_pseudo_bytes')
             ->getMock();

        $this->php
            ->expects($this->once())
            ->method('function_exists')
            ->will($this->returnValue(false));

        Str::random();
    }

    /**
     * @runInSeparateProcess
     * @expectedException \RuntimeException
     */
    public function testRandomWithFailure()
    {
        $this->php = FunctionMocker::start($this, 'Chromabits\Nucleus\Support')
             ->mockFunction('function_exists')
             ->mockFunction('openssl_random_pseudo_bytes')
             ->getMock();

        $this->php
            ->expects($this->once())
            ->method('function_exists')
            ->will($this->returnValue(true));

        $this->php
            ->expects($this->once())
            ->method('openssl_random_pseudo_bytes')
            ->will($this->returnValue(false));

        Str::random();
    }

    public function testBeginsWith()
    {
        $this->assertEqualsMatrix([
            [true, Str::beginsWith('hello world', 'hello')],
            [true, Str::beginsWith('hello world', '')],
            [false, Str::beginsWith('hello world', 'omg')],
            [false, Str::beginsWith('hello world', 'hello world ')],
        ]);
    }

    public function testEndsWith()
    {
        $this->assertEqualsMatrix([
            [true, Str::endsWith('hello world', 'world')],
            [true, Str::endsWith('hello world', '')],
            [false, Str::endsWith('hello world', 'omg')],
            [false, Str::endsWith('hello world', 'hello world ')],
        ]);
    }
}
