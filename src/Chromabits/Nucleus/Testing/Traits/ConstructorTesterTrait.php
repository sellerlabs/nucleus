<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Testing\Traits;

use Exception;

/**
 * Trait ConstructorTesterTrait.
 *
 * @property array constructorTypes
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Traits
 */
trait ConstructorTesterTrait
{
    /**
     * @return mixed
     */
    abstract protected function make();

    /**
     * Test the constructor of an object.
     *
     * Creates a new instance by using make and optionally checks
     * if it is an instance of a set of classes and interfaces
     */
    public function testConstructor()
    {
        $instance = $this->make();

        $this->assertInternalType('object', $instance);

        if (property_exists($this, 'constructorTypes')
            && count($this->constructorTypes) > 0
        ) {
            $this->assertInstanceOf($this->constructorTypes, $instance);
        }
    }

    /**
     * Assert that the provided object is an instance of a class.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return mixed
     */
    abstract public function assertInstanceOf(
        $expected,
        $actual,
        $message = ''
    );

    /**
     * Assert the provided input of a certain internal (scalar) type.
     *
     * @param string $expected
     * @param string $actual
     * @param string $message
     *
     * @return mixed
     */
    abstract public function assertInternalType(
        $expected,
        $actual,
        $message = ''
    );
}
