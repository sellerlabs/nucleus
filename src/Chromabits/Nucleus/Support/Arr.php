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

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException;
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\StaticObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;

/**
 * Class Arr.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Arr extends StaticObject
{
    /**
     * Get the resulting value of an attempt to traverse a key path.
     *
     * Each key in the path is separated with a dot.
     *
     * For example, the following snippet should return `true`:
     * ```php
     * Arr::dotGet([
     *     'hello' => [
     *         'world' => true,
     *     ],
     * ], 'hello.world');
     * ```
     *
     * Additionally, a default value may be provided, which will be returned if
     * the path does not yield to a value.
     *
     * @param array $array
     * @param string $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public static function dotGet(array $array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return Std::thunk($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Set an array element using dot notation.
     *
     * Same as `Arr::dotGet()`, but the value is replaced instead of fetched.
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     *
     * @throws LackOfCoffeeException
     */
    public static function dotSet(array $array, $key, $value)
    {
        $path = explode('.', $key);
        $total = count($path);

        $current = &$array;

        for ($ii = 0; $ii < $total; $ii++) {
            if ($ii === $total - 1) {
                $current[$path[$ii]] = $value;
            } else {
                if (!is_array($current)) {
                    throw new LackOfCoffeeException(
                        'Part of the path is not an array.'
                    );
                }

                if (!array_key_exists($path[$ii], $current)) {
                    $current[$path[$ii]] = [];
                }

                $current = &$current[$path[$ii]];
            }
        }
    }

    /**
     * Like walk() but it uses a copy of the array instead.
     *
     * @param array $array
     * @param callable $callback
     * @param bool $recurse
     * @param string $path
     * @param bool $considerLeaves
     *
     * @return array
     */
    public static function walkCopy(
        array $array,
        callable $callback,
        $recurse = false,
        $path = '',
        $considerLeaves = true
    ) {
        return static::walk(
            $array,
            $callback,
            $recurse,
            $path,
            $considerLeaves
        );
    }

    /**
     * A more complicated, but flexible, version of `array_walk`.
     *
     * This modified version is useful for flattening arrays without losing
     * important structure data (how the array is arranged and nested).
     *
     * Possible applications: flattening complex validation responses or a
     * configuration file.
     *
     * Additional features:
     * - The current path in dot notation is provided to the callback.
     * - Leaf arrays (no nested arrays) can be optionally ignored.
     *
     * Callback signature:
     * ```php
     * $callback($key, $value, $array, $path);
     * ```
     *
     * @param array $array
     * @param callable $callback
     * @param bool $recurse
     * @param string $path - The current path prefix.
     * @param bool $considerLeaves
     *
     * @return array
     */
    public static function walk(
        array &$array,
        callable $callback,
        $recurse = false,
        $path = '',
        $considerLeaves = true
    ) {
        $path = trim($path, '.');

        foreach ($array as $key => $value) {
            if (is_array($value) && $recurse) {
                if ($considerLeaves === false && !static::hasNested($value)) {
                    $callback($key, $value, $array, $path);
                    continue;
                }

                $deeperPath = $key;

                if ($path !== '') {
                    $deeperPath = vsprintf('%s.%s', [$path, $key]);
                }

                static::walk(
                    $array[$key],
                    $callback,
                    true,
                    $deeperPath,
                    $considerLeaves
                );
                continue;
            }

            $callback($key, $value, $array, $path);
        }

        return $array;
    }

    /**
     * Return whether or not an array has nested arrays.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function hasNested(array $array)
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return whether or not an array contains the specified key.
     *
     * @param array $input
     * @param string|int $key
     *
     * @return bool
     */
    public static function has(array $input, $key)
    {
        return array_key_exists($key, $input);
    }

    /**
     * Get array elements that are not null.
     *
     * @param array $properties
     * @param array|null $allowed
     *
     * @return array
     */
    public static function filterNullValues($properties, array $allowed = null)
    {
        // If provided, only use allowed properties
        $properties = static::only($properties, $allowed);

        return array_filter(
            $properties,
            function ($value) {
                return !is_null($value);
            }
        );
    }

    /**
     * Get an array with only the specified keys of the provided array.
     *
     * @param array $input
     * @param array|null $included
     *
     * @return array
     */
    public static function only(array $input, $included = [])
    {
        Arguments::define(
            Boa::either(
                Boa::arrOf(Boa::either(
                    Boa::string(),
                    Boa::integer()
                )),
                Boa::null()
            )
        )->check($included);

        if (is_null($included)) {
            return $input;
        }

        if (count($included) == 0) {
            return [];
        }

        return array_intersect_key($input, array_flip($included));
    }

    /**
     * Filter the keys of an array to only the allowed set.
     *
     * @param array $input
     * @param array $included
     *
     * @throws InvalidArgumentException
     * @return array
     * @deprecated
     */
    public static function filterKeys(array $input, $included = [])
    {
        if (is_null($included) || count($included) == 0) {
            return $input;
        }

        return array_intersect_key($input, array_flip($included));
    }

    /**
     * Get a copy of the provided array excluding the specified keys.
     *
     * @param array $input
     * @param array $excluded
     *
     * @throws InvalidArgumentException
     * @return array
     */
    public static function except(array $input, $excluded = [])
    {
        Arguments::define(Boa::arrOf(Boa::either(
            Boa::string(),
            Boa::integer()
        )))->check($excluded);

        return Std::filter(function ($_, $key) use ($excluded) {
            return !in_array($key, $excluded);
        },
            $input);
    }

    /**
     * Get a copy of the provided array excluding the specified values.
     *
     * @param array $input
     * @param array $excluded
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public static function exceptValues(array $input, $excluded = [])
    {
        Arguments::define(Boa::arrOf(Boa::either(
            Boa::string(),
            Boa::integer()
        )))->check($excluded);

        return Std::filter(function ($value, $_) use ($excluded) {
            return !in_array($value, $excluded);
        },
            $input);
    }

    /**
     * Exchange two elements in an array.
     *
     * @param array $elements
     * @param int $indexA
     * @param int $indexB
     *
     * @throws IndexOutOfBoundsException
     */
    public static function exchange(array &$elements, $indexA, $indexB)
    {
        $count = count($elements);

        if (($indexA < 0 || $indexA > ($count - 1))
            || $indexB < 0
            || $indexB > ($count - 1)
        ) {
            throw new IndexOutOfBoundsException();
        }

        $temp = $elements[$indexA];

        $elements[$indexA] = $elements[$indexB];

        $elements[$indexB] = $temp;
    }

    /**
     * Merge a vector of arrays performantly. Borrowed from libphutil.
     * This has the same semantics as array_merge(), so these calls are
     * equivalent:.
     *
     *   array_merge($a, $b, $c);
     *   array_mergev(array($a, $b, $c));
     *
     * However, when you have a vector of arrays, it is vastly more performant
     * to merge them with this function than by calling array_merge() in a loop,
     * because using a loop generates an intermediary array on each iteration.
     *
     * @param array $arrayv
     *
     * @throws InvalidArgumentException
     * @return array|mixed
     */
    public static function mergev(array $arrayv)
    {
        if (empty($arrayv)) {
            return [];
        }

        foreach ($arrayv as $key => $item) {
            if (!is_array($item)) {
                throw new InvalidArgumentException(
                    sprintf(
                        'Expected all items passed to %s to be arrays, but ' .
                        'argument with key "%s" has type "%s".',
                        __FUNCTION__ . '()',
                        $key,
                        gettype($item)));
            }
        }

        return call_user_func_array('array_merge', $arrayv);
    }

    /**
     * Get each key in an array.
     *
     * @param array $input
     *
     * @return array<string|int>
     */
    public static function keys(array $input)
    {
        return array_keys($input);
    }

    /**
     * Get the value of each element in the array.
     *
     * @param array $input
     *
     * @return array
     */
    public static function values(array $input)
    {
        return array_values($input);
    }

    /**
     * Extract the first element in an array.
     *
     * @param array $input
     *
     * @throws CoreException
     * @return mixed
     */
    public static function head(array $input)
    {
        if (count($input) === 0) {
            throw new CoreException('Empty array.');
        }

        return $input[0];
    }

    /**
     * Extract the last element of an array.
     *
     * @param array $input
     *
     * @throws CoreException
     * @return array
     */
    public static function tail(array $input)
    {
        if (count($input) === 0) {
            throw new CoreException('Empty array.');
        }

        return array_slice($input, 1);
    }

    /**
     * Extract the last element in an array.
     *
     * @param array $input
     *
     * @throws CoreException
     * @return mixed
     */
    public static function last(array $input)
    {
        if (count($input) === 0) {
            throw new CoreException('Empty array.');
        }

        return $input[count($input) - 1];
    }

    /**
     * Extract all the elements of an array except the last one.
     *
     * @param array $input
     *
     * @throws CoreException
     * @return array
     */
    public static function init(array $input)
    {
        if (count($input) === 0) {
            throw new CoreException('Empty array.');
        }

        return array_slice($input, 0, count($input) - 1);
    }

    /**
     * Return the provided array with all its elements in the inverse order.
     *
     * @param array $input
     *
     * @return array
     */
    public static function reverse(array $input)
    {
        return array_reverse($input);
    }

    /**
     * Returns the suffix of element after the first N elements.
     *
     * @param array $input
     * @param int $count
     *
     * @return array
     */
    public static function drop(array $input, $count)
    {
        return array_slice($input, $count);
    }

    /**
     * Returns the index of the first occurrence of a value in the provided
     * array.
     *
     * If the value is not found, false is returned.
     *
     * @param array $input
     * @param mixed $value
     *
     * @return int|string|bool
     */
    public static function indexOf(array $input, $value)
    {
        foreach ($input as $key => $inputValue) {
            if ($inputValue === $value) {
                return $key;
            }
        }

        return false;
    }

    /**
     * Returns the suffix of elements before the first N elements
     *
     * @param array $input
     * @param int $count
     *
     * @return array
     */
    public static function take(array $input, $count)
    {
        return array_slice($input, 0, $count);
    }

    /**
     * Merge two arrays together.
     *
     * @param array $base
     * @param array $extension
     *
     * @return array
     */
    public static function merge(array $base, array $extension)
    {
        return array_merge($base, $extension);
    }

    /**
     * Check if an array contains the provided value.
     *
     * @param array $input
     * @param mixed $value
     *
     * @return bool
     */
    public static function in(array $input, $value)
    {
        return in_array($value, $input);
    }
}
