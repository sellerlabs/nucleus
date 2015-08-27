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
use Chromabits\Nucleus\Strings\Rope;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

if (!function_exists('rope')) {
    /**
     * Create a new instance of a rope.
     *
     * @param string $str
     * @param null $encoding
     *
     * @return Rope
     */
    function rope($str, $encoding = null)
    {
        return Std::rope($str, $encoding);
    }
}

if (!function_exists('within')) {
    /**
     * Check if a value is between two other values.
     *
     * @param int|float $min
     * @param int|float $max
     * @param int|float $value
     *
     * @throws LackOfCoffeeException
     * @return bool
     */
    function within($min, $max, $value)
    {
        return Std::within($min, $max, $value);
    }
}

if (!function_exists('coalesce')) {
    /**
     * Return the first non-null argument.
     *
     * @param mixed ...$args
     *
     * @return mixed
     */
    function coalesce(...$args)
    {
        return Std::coalesce(...$args);
    }
}

if (!function_exists('truthy')) {
    /**
     * Return the first non-false argument.
     *
     * @param mixed ...$args
     *
     * @return mixed
     */
    function truthy(...$args)
    {
        return Std::truthy(...$args);
    }
}

if (!function_exists('nucleus_escape_html')) {
    /**
     * Escape the provided input for HTML.
     *
     * @param string $string
     *
     * @return string
     */
    function nucleus_escape_html($string)
    {
        return Std::esc($string);
    }
}

if (!function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        return Arr::dotGet($array, $key, $default);
    }
}
