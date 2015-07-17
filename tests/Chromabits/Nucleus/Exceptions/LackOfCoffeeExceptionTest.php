<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Exceptions;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class LackOfCoffeeExceptionTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Exceptions
 */
class LackOfCoffeeExceptionTest extends TestCase
{
    public function testConstructor()
    {
        $one = new LackOfCoffeeException();

        $this->assertEquals(
            "(╯°□°）╯︵ ┻━┻ Coffee time!",
            $one->getMessage()
        );

        $two = new LackOfCoffeeException('You need some sleep man');

        $this->assertEquals(
            '(╯°□°）╯︵ ┻━┻ You need some sleep man',
            $two->getMessage()
        );
    }
}
