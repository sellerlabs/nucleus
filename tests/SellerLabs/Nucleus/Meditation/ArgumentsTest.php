<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Meditation\Arguments;
use SellerLabs\Nucleus\Meditation\Constraints\EitherConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\MaybeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use SellerLabs\Nucleus\Meditation\Primitives\CompoundTypes;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class ArgumentsTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation
 */
class ArgumentsTest extends TestCase
{
    public function testDefine()
    {
        Arguments::define(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow');
    }

    public function testDefineWithMismatch()
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            'Argument number mismatch.'
        );

        Arguments::define(
            PrimitiveTypeConstraint::forType(ScalarTypes::SCALAR_STRING)
        )->check('wow', new stdClass());
    }

    public function testDefineWithInvalid()
    {
        $definition = Arguments::define(
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
