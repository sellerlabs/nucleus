<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Meditation\Primitives;

use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class CompoundTypesTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Primitives
 */
class CompoundTypesTest extends TestCase
{
    public function testGetTypeDefined()
    {
        $instance = new CompoundTypes();

        $this->assertIsArray($instance->getTypesDefined());
        $this->assertNotEmpty($instance->getTypesDefined());
    }

    public function testGetCompounds()
    {
        $instance = new CompoundTypes();

        $this->assertIsArray($instance->getCompounds());
        $this->assertNotEmpty($instance->getTypesDefined());
    }
}
