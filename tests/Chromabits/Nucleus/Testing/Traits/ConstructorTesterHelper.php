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
use Chromabits\Nucleus\Testing\Traits\ConstructorTesterTrait;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class ConstructorTesterHelper.
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
        'Chromabits\Nucleus\Testing\TestCase',
    ];

    /**
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function make()
    {
        return $this->getMockForAbstractClass(TestCase::class);
    }

    /**
     * Sets multiple types.
     */
    public function setMultipleTypes()
    {
        $this->constructorTypes = [
            '\PHPUnit_Framework_TestCase',
            'Chromabits\Nucleus\Testing\TestCase',
        ];
    }

    /**
     * Sets no types.
     */
    public function setNoTypes()
    {
        $this->constructorTypes = [];
    }
}
