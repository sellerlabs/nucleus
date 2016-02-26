<?php

namespace Chromabits\Nucleus\Data\Exceptions;

use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class MismatchedDataTypesExceptionTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Exceptions
 */
class MismatchedDataTypesExceptionTest extends TestCase
{
    public function testCreate()
    {
        $instance = MismatchedDataTypesException::create(
            ScalarTypes::SCALAR_STRING,
            ScalarTypes::SCALAR_BOOLEAN
        );

        $this->assertInstanceOf(MismatchedDataTypesException::class, $instance);
    }

    public function testSetExpectedAndReceived()
    {
        $instance = new MismatchedDataTypesException(
            ScalarTypes::SCALAR_FLOAT,
            45
        );

        $instance->setExpectedAndReceived(
            ScalarTypes::SCALAR_STRING,
            true
        );

        $this->assertEquals(
            ScalarTypes::SCALAR_STRING,
            $instance->getExpected()
        );
        $this->assertEquals(
            ScalarTypes::SCALAR_BOOLEAN,
            $instance->getReceived()
        );
    }
}
