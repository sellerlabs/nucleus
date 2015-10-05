<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Foundation;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use DomainException;
use Iterator;

/**
 * Class BaseObject.
 *
 *  * A base object class based of Libphutil's Phobject class.
 *
 * - (NEW) Prevent the constructor of an object being called with additional
 * parameters by accident.
 * - Protect against the use of undefined properties.
 * - Prevent accidental object iteration on objects.
 *
 * See: <libphutil>/src/object/Phobject.php
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation
 */
class BaseObject implements Iterator
{
    /**
     * Construct an instance of a BaseObject.
     *
     * @throws LackOfCoffeeException
     */
    public function __construct()
    {
        $argCount = func_num_args();

        if ($argCount > 0) {
            throw new LackOfCoffeeException(vsprintf(
                'The constructor of the class %s only accepts 0 arguments,'
                . ' however, it was called with %d arguments.',
                [static::class, $argCount]
            ));
        }
    }

    /**
     * @param string $name
     */
    public function __get($name)
    {
        throw new DomainException(
            sprintf(
                'Attempt to read from undeclared property %s.',
                get_class($this) . '::' . $name
            )
        );
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        throw new DomainException(
            sprintf(
                'Attempt to write to undeclared property %s.',
                get_class($this) . '::' . $name
            )
        );
    }

    /**
     * Get the current element.
     */
    public function current()
    {
        $this->throwOnAttemptedIteration();
    }

    /**
     * Get the key of the current of element.
     */
    public function key()
    {
        $this->throwOnAttemptedIteration();
    }

    /**
     * Get the next.
     */
    public function next()
    {
        $this->throwOnAttemptedIteration();
    }

    /**
     * Rewind the iterator to the first element.
     */
    public function rewind()
    {
        $this->throwOnAttemptedIteration();
    }

    /**
     * Return whether or not the iterator is in a valid position.
     */
    public function valid()
    {
        $this->throwOnAttemptedIteration();
    }

    /**
     * Throw a new attempted iteration exception.
     */
    private function throwOnAttemptedIteration()
    {
        throw new DomainException(
            sprintf(
                'Attempting to iterate an object (of class %s) which is not'
                . ' iterable.',
                get_class($this)
            )
        );
    }
}
