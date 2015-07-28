<?php

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Constraints\EitherConstraint;
use Chromabits\Nucleus\Meditation\Constraints\MaybeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use stdClass;

/**
 * Class ArgumentsTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class ArgumentsTest extends TestCase
{
    public function testContain()
    {
        Arguments::contain(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow');
    }

    public function testContainWithMismatch()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'Argument number mismatch.'
        );

        Arguments::contain(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow', new stdClass());
    }

    public function testContainWithInvalid()
    {
        $definition = Arguments::contain(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING),
            EitherConstraint::create(
                MaybeConstraint::forType(PrimitiveTypeConstraint::forType(
                    CompoundTypes::COMPOUND_ARRAY
                )),
                PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_BOOLEAN)
            )
        );

        $definition->check('wow', true);
        $definition->check('wow', []);
        $definition->check('wow', null);

        $this->setExpectedException(InvalidArgumentException::class);

        $definition->check('wow', 25);
    }
}
