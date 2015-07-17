<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;

if (!function_exists('within')) {
    /**
     * Check if a value is between two other values.
     *
     * @param $min
     * @param $max
     * @param $value
     *
     * @return bool
     * @throws LackOfCoffeeException
     */
    function within($min, $max, $value)
    {
        if ($min > $max) {
            throw new LackOfCoffeeException(
                'Max value is less than the min value.'
            );
        }

        return ($min <= $value && $max >= $value);
    }
}

if (!function_exists('coalesce')) {
    /**
     * Return the first non-null argument.
     *
     * @param ...$args
     *
     * @return null
     */
    function coalesce(...$args)
    {
        foreach ($args as $arg) {
            if ($arg !== null) {
                return $arg;
            }
        }

        return null;
    }
}
