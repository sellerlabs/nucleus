<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Meditation\Constraints;

use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\CompoundTypes;
use SellerLabs\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class PrimitiveConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation\Constraints
 */
class PrimitiveConstraintTest extends TestCase
{
    public function testCheck()
    {
        $instance = new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_OBJECT);

        $this->assertEqualsMatrix([
            [false, $instance->check(null)],
            [false, $instance->check('hello world')],
            [false, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [false, $instance->check(276.564)],
            [true, $instance->check(new stdClass())],
        ]);
    }
}
