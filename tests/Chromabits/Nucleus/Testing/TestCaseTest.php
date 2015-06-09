<?php

namespace Tests\Chromabits\Nucleus\Testing;

use Chromabits\Nucleus\Testing\TestCase;
use PHPUnit_Framework_TestCase;
use ArrayIterator;

/**
 * Class TestCaseTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus
 */
class TestCaseTest extends PHPUnit_Framework_TestCase
{
    public function testAssertInstanceOf()
    {
        $case = new TestCase();

        $case->assertInstanceOf(
            ['ArrayIterator', 'Iterator'],
            new ArrayIterator()
        );

        $case->assertInstanceOf('ArrayIterator', new ArrayIterator());

        $case->assertInstanceOf('Iterator', new ArrayIterator());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInstanceOfWithInvalid()
    {
        $case = new TestCase();

        $case->assertInstanceOf('EmptyIterator', new ArrayIterator());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInstanceOfWithMultipleInvalid()
    {
        $case = new TestCase();

        $case->assertInstanceOf(
            ['ArrayIterator', 'EmptyIterator'],
            new ArrayIterator()
        );
    }
}
