<?php

namespace Tests\Chromabits\Nucleus\Meditation\Primitives;

use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ScalarTypesTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation\Primitives
 */
class ScalarTypesTest extends TestCase
{
    public function testGetTypesDefined()
    {
        $instance = new ScalarTypes();

        $this->assertIsArray($instance->getTypesDefined());
        $this->assertNotEmpty($instance->getTypesDefined());
    }

    public function testGetScalars()
    {
        $instance = new ScalarTypes();

        $this->assertIsArray($instance->getScalars());
        $this->assertNotEmpty($instance->getScalars());
    }
}
