<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Validation\Constraints;

use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\Validation\Constraints\StringLengthConstraint;

/**
 * Class StringLengthConstraintTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Validation\Constraints
 */
class StringLengthConstraintTest extends TestCase
{
    public function testCheck()
    {
        $one = new StringLengthConstraint();
        $two = new StringLengthConstraint(5);
        $three = new StringLengthConstraint(10, 15);

        $this->assertEqualsMatrix([
            [true, $one->check('')],
            [true, $one->check('abcdefg')],
            [false, $two->check('')],
            [false, $two->check('abcd')],
            [true, $two->check('abcde')],
            [true, $two->check('abcdefghijklmnop')],
            [false, $three->check('')],
            [false, $three->check('123456789')],
            [true, $three->check('1234567890')],
            [true, $three->check('1234567890a')],
            [true, $three->check('abcdefghijklmno')],
            [false, $three->check('abcdefghijklmnop')],
            [false, $three->check('abcdefghijklmnopqrs')],
        ]);
    }

    public function testToString()
    {
        $one = new StringLengthConstraint();
        $two = new StringLengthConstraint(5);
        $three = new StringLengthConstraint(10, 15);

        $this->assertEqualsMatrix([
            ['{length: 0 <= x}', $one->toString()],
            ['{length: 5 <= x}', $two->toString()],
            ['{length: 10 <= x <= 15}', $three->toString()],
        ]);
    }

    public function testGetDescription()
    {
        $one = new StringLengthConstraint();
        $two = new StringLengthConstraint(5);
        $three = new StringLengthConstraint(10, 15);

        $this->assertEqualsMatrix([
            [
                'The value is expected to have a length greater or equal to'
                . ' 0 (0 <= x).',
                $one->getDescription(),
            ],
            [
                'The value is expected to have a length greater or equal to'
                . ' 5 (5 <= x).',
                $two->getDescription(),
            ],
            [
                'The value is expected to have a length between 10 and 15'
                . ' (10 <= x <= 15).',
                $three->getDescription(),
            ],
        ]);
    }
}
