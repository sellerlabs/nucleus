<?php

namespace Tests\Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Strings\Rope;
use Chromabits\Nucleus\Testing\TestCase;
use Exception;
use stdClass;

/**
 * Class ClassTypeConstraintTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Constraints
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
            [true, $instance->check(rope('some random string'))],
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
