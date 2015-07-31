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

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Strings\Rope;
use Closure;

/**
 * Class Std.
 *
 * A standard library of functions.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Std extends BaseObject
{
    /**
     * Return the default value of the given value.
     *
     * @param Closure|mixed $value
     *
     * @return mixed
     */
    public static function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }

    /**
     * Return the first non-false argument.
     *
     * @param mixed ...$args
     *
     * @return bool
     */
    public static function truthy(...$args)
    {
        foreach ($args as $arg) {
            if ($arg) {
                return $arg;
            }
        }

        return false;
    }

    /**
     * Return the first non-null argument.
     *
     * @param mixed ...$args
     *
     * @return null
     */
    public static function coalesce(...$args)
    {
        foreach ($args as $arg) {
            if ($arg !== null) {
                return $arg;
            }
        }

        return null;
    }

    /**
     * Return the first non-empty argument.
     *
     * @param mixed ...$args
     *
     * @return null
     */
    public static function nonempty(...$args)
    {
        foreach ($args as $arg) {
            if (!empty($arg)) {
                return $arg;
            }
        }

        return null;
    }

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
    public static function within($min, $max, $value)
    {
        if ($min > $max) {
            throw new LackOfCoffeeException(
                'Max value is less than the min value.'
            );
        }

        return ($min <= $value && $max >= $value);
    }

    /**
     * Create a new instance of a rope.
     *
     * @param string $str
     * @param null $encoding
     *
     * @return Rope
     */
    public static function rope($str, $encoding = null)
    {
        return new Rope($str, $encoding);
    }

    /**
     * Escape the provided input for HTML.
     *
     * @param string $string
     *
     * @return string
     */
    public static function esc($string)
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
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
    public static function callSetters(
        $object,
        array $input,
        array $allowed = []
    ) {
        $filtered = Arr::filterKeys($input, $allowed);

        foreach ($filtered as $key => $value) {
            $setterName = 'set' . Str::studly($key);

            $object->$setterName($value);
        }
    }

    /**
     * Return the first value if the condition is true, otherwise, return the
     * second.
     *
     * @param bool $biased
     * @param mixed|Closure $first
     * @param mixed|Closure $second
     *
     * @return mixed
     */
    public static function firstBias($biased, $first, $second)
    {
        if ($biased) {
            return static::value($first);
        }

        return static::value($second);
    }

    /**
     * Placeholder.
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     *
     * @return string
     */
    public static function jsonEncode($value, $options = 0, $depth = 512)
    {
        return json_encode($value, $options, $depth);
    }

    /**
     * Placeholder.
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     *
     * @return mixed
     */
    public static function jsonDecode($value, $options = 0, $depth = 512)
    {
        return json_decode($value, true, $options, $depth);
    }
}
