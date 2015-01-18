<?php

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\Str;
use Chromabits\Nucleus\Testing\TestCase;
use PHPUnit_Extension_FunctionMocker;

/**
 * Class StrTest
 *
 * @package Tests\Chromabits\Nucleus\Support
 */
class StrTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $php;

    public function testConstructor()
    {
        $this->assertInstanceOf('Chromabits\Nucleus\Support\Str', new Str());
    }

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
        $this->assertEquals('studly_case_stuff', $str->snake('StudlyCaseStuff'));
    }

    public function testCamelCache()
    {
        $str = new Str();

        $str->setCamelCache([
            "this_is_cached" => 'This is cached'
        ]);

        $this->assertEquals('This is cached', $str->camel('this_is_cached'));
    }

    public function testStudlyCache()
    {
        $str = new Str();

        $str->setStudlyCache([
            "this_is_cached" => 'This is cached'
        ]);

        $this->assertEquals('This is cached', $str->studly('this_is_cached'));
    }

    public function testSnakeCache()
    {
        $str = new Str();

        $str->setSnakeCache([
            "thisIsCached_" => 'This is cached'
        ]);

        $this->assertEquals('This is cached', $str->snake('thisIsCached'));
    }

    public function testQuickRandom()
    {
        $randomInteger = mt_rand(1, 100);

        $str = new Str();

        $this->assertEquals($randomInteger, strlen($str->quickRandom($randomInteger)));
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

        $randomInteger = mt_rand(1, 100);
        $this->assertEquals($randomInteger, strlen($str->random($randomInteger)));
        $this->assertInternalType('string', $str->random());
    }

    /**
     * @runInSeparateProcess
     * @expectedException \RuntimeException
     */
    public function testRandomWithMissingFunction()
    {
        $this->php = PHPUnit_Extension_FunctionMocker::start($this, 'Chromabits\Nucleus\Support')
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
        $this->php = PHPUnit_Extension_FunctionMocker::start($this, 'Chromabits\Nucleus\Support')
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
