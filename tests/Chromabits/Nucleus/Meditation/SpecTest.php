<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Testing\TestCase;
use stdClass;

/**
 * Class SpecTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class SpecTest extends TestCase
{
    /**
     * @throws \Chromabits\Nucleus\Exceptions\LackOfCoffeeException
     */
    public function testCheck()
    {
        $instance = new Spec([
            'name' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'count' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER),
            'exception' => new ClassTypeConstraint(CoreException::class),
        ]);

        $this->assertEqualsMatrix([
            [true, $instance->check([
                'name' => 'Git',
                'count' => 101,
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 0,
                'count' => 101,
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 'Git',
                'count' => [],
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 'Git',
                'count' => 101,
                'exception' => new stdClass(),
            ])->passed()],
            [false, $instance->check([
                'name' => 0,
                'count' => 101,
                'exception' => new stdClass(),
            ])->passed()],
        ]);
    }
}
