<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Testing;

use ArrayIterator;
use Chromabits\Nucleus\Testing\TestCase;
use PHPUnit_Framework_TestCase;

/**
 * Class TestCaseTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing
 */
class TestCaseTest extends PHPUnit_Framework_TestCase
{
    public function testAssertInstanceOf()
    {
        /** @var TestCase $case */
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
        /** @var TestCase $case */
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf('EmptyIterator', new ArrayIterator());
    }

    /**
     * @expectedException \PHPUnit_Framework_ExpectationFailedException
     */
    public function testAssertInstanceOfWithMultipleInvalid()
    {
        /** @var TestCase $case */
        $case = $this->getMockForAbstractClass(TestCase::class);

        $case->assertInstanceOf(
            ['ArrayIterator', 'EmptyIterator'],
            new ArrayIterator()
        );
    }
}
