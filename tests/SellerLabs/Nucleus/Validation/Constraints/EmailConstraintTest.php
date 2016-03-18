<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Validation\Constraints;

use SellerLabs\Nucleus\Testing\TestCase;
use SellerLabs\Nucleus\Validation\Constraints\EmailConstraint;

/**
 * Class EmailConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Validation\Constraints
 */
class EmailConstraintTest extends TestCase
{
    public function testCheck()
    {
        $constraint = new EmailConstraint();

        $this->assertEqualsMatrix([
            [true, $constraint->check('doge@wow.inc')],
            [true, $constraint->check('doge+support@wow.inc')],
            [true, $constraint->check('do.ge@wow.inc')],
            [false, $constraint->check('doge@@wow.inc')],
            [false, $constraint->check('wow.inc')],
            [false, $constraint->check('doge@')],
            [false, $constraint->check('@wow.inc')],
            [false, $constraint->check('doge (at) wow.inc')],
        ]);
    }

    public function testToString()
    {
        $constraint = new EmailConstraint();

        $this->assertEquals('{email}', $constraint->toString());
    }

    public function testGetDescription()
    {
        $constraint = new EmailConstraint();

        $this->assertEquals(
            'The value is expected to be a valid email address.',
            $constraint->getDescription()
        );
    }
}
