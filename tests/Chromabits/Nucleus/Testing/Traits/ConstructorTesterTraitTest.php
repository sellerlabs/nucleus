<?php

namespace Tests\Chromabits\Nucleus\Testing\Traits;

use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ConstructorTesterTraitTest
 *
 * @package tests\Chromabits\Nucleus\Testing\Traits
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

    /**
     * @expectedException \Exception
     */
    public function testTestConstructorWithInvalid()
    {
        $helper = new InvalidConstructorTesterHelper();

        $helper->testConstructor();
    }
}
