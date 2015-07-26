<?php

namespace Tests\Chromabits\Nucleus\Meditation\Exceptions;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class UnknownTypeExceptionTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Exceptions
 */
class UnknownTypeExceptionTest extends TestCase
{
    public function testException()
    {
        $instance = new UnknownTypeException(
            'string',
            255,
            new CoreException()
        );

        $this->setExpectedException(
            UnknownTypeException::class,
            'The type string is unknown.',
            255
        );

        throw $instance;
    }
}
