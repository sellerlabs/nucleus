<?php

namespace Chromabits\Nucleus\Testing\Traits;

use Exception;

/**
 * Trait ConstructorTesterTrait
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Traits
 */
trait ConstructorTesterTrait
{
    /**
     * Test the constructor of an object
     *
     * Creates a new instance by using make and optionally checks
     * if it is an instance of a set of classes and interfaces
     */
    public function testConstructor()
    {
        // If we don't have a factory function, the we don't really know
        // how to make the object we are testing
        if (!method_exists($this, 'make')) {
            throw new Exception(
                'Unable to test constructor. Factory function is not defined'
            );
        }

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
     * @param $expected
     * @param $actual
     * @param string $message
     *
     * @return mixed
     */
    public abstract function assertInstanceOf(
        $expected,
        $actual,
        $message = ''
    );

    /**
     * Assert the provided input of a certain internal (scalar) type.
     *
     * @param $expected
     * @param $actual
     * @param string $message
     *
     * @return mixed
     */
    public abstract function assertInternalType(
        $expected,
        $actual,
        $message = ''
    );
}
