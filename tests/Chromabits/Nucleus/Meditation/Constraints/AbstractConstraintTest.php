<?php

namespace Tests\Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class AbstractConstraintTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package tests\Chromabits\Nucleus\Meditation\Constraints
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