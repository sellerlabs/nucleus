<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Meditation\Primitives;

use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Testing\TestCase;

/**
 * Class ScalarTypesTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation\Primitives
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
