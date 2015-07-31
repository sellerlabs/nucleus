<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Support;

/**
 * Class ArrayUtils.
 *
 * Array utility functions
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @deprecated Since 0.3.0
 * @package Chromabits\Nucleus\Support
 */
class ArrayUtils
{
    /**
     * Get array elements that are not null.
     *
     * @param array $properties
     * @param array $allowed
     * @return array
     */
    public function filterNullValues($properties, array $allowed = null)
    {
        return Arr::filterNullValues($properties, $allowed);
    }

    /**
     * Set properties of an object by only calling setters of array keys that
     * are set in the input array. Useful for parsing API responses into
     * entities.
     *
     * @param object $object
     * @param array $input
     * @param array $allowed
     */
    public function callSetters($object, array $input, array $allowed = [])
    {
        Std::callSetters($object, $input, $allowed);
    }

    /**
     * Filter the keys of an array to only the allowed set.
     *
     * @param array $input
     * @param array $allowed
     * @return array
     */
    public function filterKeys($input, $allowed = [])
    {
        return Arr::filterKeys($input, $allowed);
    }

    /**
     * Exchange two elements in an array.
     *
     * @param array $elements
     * @param int $indexA
     * @param int $indexB
     *
     * @throws \Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException
     */
    public function exchange(array &$elements, $indexA, $indexB)
    {
        Arr::exchange($elements, $indexA, $indexB);
    }
}
