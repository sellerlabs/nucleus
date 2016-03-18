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

use SellerLabs\Nucleus\Meditation\Constraints\AbstractConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class AbstractConstraintTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation\Constraints
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
