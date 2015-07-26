<?php

namespace Tests\Chromabits\Nucleus\Meditation\Primitives;

use Chromabits\Nucleus\Meditation\Primitives\SpecialTypes;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class SpecialTypesTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Primitives
 */
class SpecialTypesTest extends TestCase
{
    public function testGetTypesDefined()
    {
        $instance = new SpecialTypes();

        $this->assertIsArray($instance->getTypesDefined());
        $this->assertNotEmpty($instance->getTypesDefined());
    }

    public function testGetScalars()
    {
        $instance = new SpecialTypes();

        $this->assertIsArray($instance->getSpecial());
        $this->assertNotEmpty($instance->getSpecial());
    }
}
