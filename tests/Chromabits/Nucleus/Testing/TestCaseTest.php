<?php

namespace Tests\Chromabits\Nucleus\Testing;

use Chromabits\Nucleus\Testing\TestCase;
use PHPUnit_Framework_TestCase;
use ArrayIterator;

/**
 * Class TestCaseTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing
 */
class TestCaseTest extends PHPUnit_Framework_TestCase
{
    public function testAssertInstanceOf()
    {
        $case = $this->getMockForAbstractClass(TestCase::class);

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
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf('EmptyIterator', new ArrayIterator());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInstanceOfWithMultipleInvalid()
    {
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf(
            ['ArrayIterator', 'EmptyIterator'],
            new ArrayIterator()
        );
    }
}
