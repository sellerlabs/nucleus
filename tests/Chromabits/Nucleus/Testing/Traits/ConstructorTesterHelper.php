<?php

namespace Tests\Chromabits\Nucleus\Testing\Traits;

use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\Testing\Traits\ConstructorTesterTrait;

/**
 * Class ConstructorTesterHelper
 *
 * This is not a unit test. It's merely a class for testing a trait
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing\Traits
 */
class ConstructorTesterHelper extends TestCase
{
    use ConstructorTesterTrait;

    protected $constructorTypes = [
        'Chromabits\Nucleus\Testing\TestCase'
    ];

    protected function make()
    {
        return $this->getMockForAbstractClass(TestCase::class);
    }

    public function setMultipleTypes()
    {
        $this->constructorTypes = [
            '\PHPUnit_Framework_TestCase',
            'Chromabits\Nucleus\Testing\TestCase'
        ];
    }

    public function setNoTypes()
    {
        $this->constructorTypes = [];
    }
}
