<?php

namespace Tests\Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Meditation\Constraints\ClosureConstraint;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ClosureConstraintTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Constraints
 */
class ClosureConstraintTest extends TestCase
{
    public function testCheck()
    {
        $constraint = new ClosureConstraint(function ($value) {
            return is_array($value);
        });

        $this->assertEqualsMatrix([
            [true, $constraint->check([])],
            [true, $constraint->check(['wow', 'cool'])],
            [false, $constraint->check(false)],
        ]);
    }

    public function testCheckWithInvalid()
    {
        $constraint = new ClosureConstraint(function () {
            return 1;
        });

        $this->setExpectedException(LackOfCoffeeException::class);
        $constraint->check(45);
    }

    public function testGetDescription()
    {
        $constraint = new ClosureConstraint(function ($value) {
            return is_array($value);
        }, 'wow, doges are much special');

        $this->assertEquals(
            'wow, doges are much special',
            $constraint->getDescription()
        );
    }
}
