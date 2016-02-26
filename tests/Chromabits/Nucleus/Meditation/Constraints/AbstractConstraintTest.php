<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class AbstractConstraintTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Constraints
 */
class AbstractConstraintTest extends TestCase
{
    public function testGetDescription()
    {
        $mock = Mockery::mock(AbstractConstraint::class)->makePartial();
        $mock->shouldDeferMissing();

        $this->assertInternalType(
            ScalarTypes::SCALAR_STRING,
            $mock->getDescription()
        );
    }
}
