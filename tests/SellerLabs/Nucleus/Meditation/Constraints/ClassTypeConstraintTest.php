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

use SellerLabs\Nucleus\Exceptions\CoreException;
use SellerLabs\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use SellerLabs\Nucleus\Meditation\Exceptions\UnknownTypeException;
use SellerLabs\Nucleus\Strings\Rope;
use SellerLabs\Nucleus\Testing\TestCase;
use Exception;
use stdClass;

/**
 * Class ClassTypeConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation\Constraints
 */
class ClassTypeConstraintTest extends TestCase
{
    public function testCheck()
    {
        $instance = new ClassTypeConstraint(Rope::class);

        $this->assertEqualsMatrix([
            [false, $instance->check(null)],
            [false, $instance->check('hello world')],
            [false, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [false, $instance->check(276.564)],
            [false, $instance->check(new stdClass())],
            [true, $instance->check(Rope::of('some random string'))],
        ]);
    }

    public function testCheckWithParent()
    {
        $instance = new ClassTypeConstraint(CoreException::class);

        $this->assertEqualsMatrix([
            [true, $instance->check(new UnknownTypeException('something'))],
            [true, $instance->check(new CoreException())],
            [false, $instance->check(new Exception())],
        ]);
    }

    public function testToString()
    {
        $instance = new ClassTypeConstraint(CoreException::class);

        $this->assertEquals(CoreException::class, $instance->toString());
    }

    public function testIsUnion()
    {
        $instance = new ClassTypeConstraint(CoreException::class);

        $this->assertFalse($instance->isUnion());
    }
}
