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

use SellerLabs\Nucleus\Meditation\Constraints\MaybeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class MaybeConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation\Constraints
 */
class MaybeConstraintTest extends TestCase
{
    public function testCheck()
    {
        $instance = new MaybeConstraint(
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING)
        );

        $this->assertEqualsMatrix([
            [true, $instance->check(null)],
            [true, $instance->check('hello world')],
            [true, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [false, $instance->check(276.564)],
            [false, $instance->check(new stdClass())],
        ]);
    }
}
