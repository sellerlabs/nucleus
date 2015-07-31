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
        $str = new Str();

        $this->assertEquals('snakeCaseStuff', $str->camel('snake_case_stuff'));
        $this->assertEquals('studlyCaseStuff', $str->camel('StudlyCaseStuff'));
    }

    public function testStudly()
    {
        $str = new Str();

        $this->assertEquals('SnakeCaseStuff', $str->studly('snake_case_stuff'));
        $this->assertEquals('CamelCaseStuff', $str->studly('camelCaseStuff'));
    }

    public function testSnake()
    {
        $str = new Str();

        $this->assertEquals('camel_case_stuff', $str->snake('camelCaseStuff'));
        $this->assertEquals(
            'studly_case_stuff',
            $str->snake('StudlyCaseStuff')
        );
    }

    public function testQuickRandom()
    {
        $someInteger = mt_rand(1, 100);

        $str = new Str();

        $this->assertEquals(
            $someInteger,
            strlen($str->quickRandom($someInteger))
        );
        $this->assertInternalType('string', $str->quickRandom());
        $this->assertEquals(16, strlen($str->quickRandom()));
    }

    /**
     * @runInSeparateProcess
     */
    public function testRandom()
    {
        $str = new Str();

        $this->assertEquals(16, strlen($str->random()));

        $someInteger = mt_rand(1, 100);
        $this->assertEquals($someInteger, strlen($str->random($someInteger)));
        $this->assertInternalType('string', $str->random());
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

        $str = new Str();

        $str->random();
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

        $str = new Str();

        $str->random();
    }
}
