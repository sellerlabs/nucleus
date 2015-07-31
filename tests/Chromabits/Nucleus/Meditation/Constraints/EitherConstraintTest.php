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

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\EitherConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class EitherConstraintTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Constraints
 */
class EitherConstraintTest extends TestCase
{
    public function testCheck()
    {
        $instance = new EitherConstraint(
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
        );

        $this->assertEqualsMatrix([
            [false, $instance->check(null)],
            [true, $instance->check('hello world')],
            [true, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [true, $instance->check(276.564)],
            [false, $instance->check(new stdClass())],
        ]);
    }

    public function testCheckWithClasses()
    {
        $instance = new EitherConstraint(
            new ClassTypeConstraint(CoreException::class),
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
        );

        $this->assertEqualsMatrix([
            [false, $instance->check(null)],
            [false, $instance->check('hello world')],
            [false, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [true, $instance->check(276.564)],
            [false, $instance->check(new stdClass())],
            [true, $instance->check(new CoreException())],
            [true, $instance->check(new UnknownTypeException('doge'))],
            [false, $instance->check(['omg', 'doge', 'yes'])],
            [false, $instance->check([])],
        ]);
    }

    public function testCheckWithChained()
    {
        $instance = new EitherConstraint(
            new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY),
            new EitherConstraint(
                new ClassTypeConstraint(CoreException::class),
                new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
            )
        );

        $this->assertEqualsMatrix([
            [false, $instance->check(null)],
            [false, $instance->check('hello world')],
            [false, $instance->check('hello world' . null)],
            [false, $instance->check(27645)],
            [true, $instance->check(276.564)],
            [false, $instance->check(new stdClass())],
            [true, $instance->check(new CoreException())],
            [true, $instance->check(new UnknownTypeException('doge'))],
            [true, $instance->check(['omg', 'doge', 'yes'])],
            [true, $instance->check([])],
        ]);
    }

    public function testToString()
    {
        $instance = new EitherConstraint(
            new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY),
            new EitherConstraint(
                new ClassTypeConstraint(CoreException::class),
                new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
            )
        );

        $expected = CompoundTypes::COMPOUND_ARRAY . '|(' . CoreException::class
            . '|' . ScalarTypes::SCALAR_FLOAT . ')';

        $this->assertEquals($expected, $instance->toString());
        $this->assertEquals($expected, $instance->__toString());
        $this->assertEquals($expected, (string) $instance);
    }

    public function testIsUnion()
    {
        $instance = new EitherConstraint(
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
        );

        $this->assertTrue($instance->isUnion());
    }
}
