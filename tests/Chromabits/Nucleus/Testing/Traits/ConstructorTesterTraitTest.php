<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Testing\Traits;

use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ConstructorTesterTraitTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing\Traits
 */
class ConstructorTesterTraitTest extends TestCase
{
    public function testTestConstructor()
    {
        $helper = new ConstructorTesterHelper();

        $helper->testConstructor();
    }

    public function testTestConstructorWithMultiple()
    {
        $helper = new ConstructorTesterHelper();

        $helper->setMultipleTypes();

        $helper->testConstructor();
    }

    public function testTestConstructorWithNone()
    {
        $helper = new ConstructorTesterHelper();

        $helper->setNoTypes();

        $helper->testConstructor();
    }
}
