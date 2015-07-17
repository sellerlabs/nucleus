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

use Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException;

/**
 * Class ArrayUtils
 *
 * Array utility functions
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class ArrayUtils
{
    /**
     * Get array elements that are not null
     *
     * @param $properties
     * @param array $allowed
     * @return array
     */
    public function filterNullValues($properties, array $allowed = null)
    {
        // If provided, only use allowed properties
        $properties = $this->filterKeys($properties, $allowed);

        return array_filter($properties, function ($value) {
            return !is_null($value);
        });
    }

    /**
     * Set properties of an object by only calling setters of array keys that
     * are set in the input array. Useful for parsing API responses into
     * entities.
     *
     * @param $object
     * @param array $input
     * @param array $allowed
     */
    public function callSetters($object, array $input, array $allowed = [])
    {
        $filtered = $this->filterKeys($input, $allowed);

        foreach ($filtered as $key => $value) {
            $setterName = 'set' . Str::studly($key);

            $object->$setterName($value);
        }
    }

    /**
     * Filter the keys of an array to only the allowed set
     *
     * @param $input
     * @param array $allowed
     * @return array
     */
    public function filterKeys($input, $allowed = [])
    {
        if (is_null($allowed) || count($allowed) == 0) {
            return $input;
        }

        return array_intersect_key($input, array_flip($allowed));
    }

    /**
     * Exchange two elements in an array
     *
     * @param array $elements
     * @param int $indexA
     * @param int $indexB
     *
     * @throws \Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException
     */
    public function exchange(array &$elements, $indexA, $indexB)
    {
        $count = count($elements);

        if (($indexA < 0 || $indexA > ($count - 1))
            || $indexB < 0 || $indexB > ($count - 1)
        ) {
            throw new IndexOutOfBoundsException();
        }

        $temp = $elements[$indexA];

        $elements[$indexA] = $elements[$indexB];

        $elements[$indexB] = $temp;
    }
}
