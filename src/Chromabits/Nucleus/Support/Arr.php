<?php

namespace Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Exceptions\IndexOutOfBoundsException;
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;

/**
 * Class Arr
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Arr
{
    /**
     * @param array $array
     * @param string $key
     * @param null|mixed $default
     *
     * @return mixed
     */
    public static function dotGet($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return Std::value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Set an array element using dot notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     *
     * @throws LackOfCoffeeException
     */
    public static function dotSet($array, $key, $value)
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
     * @param array $array
     * @param callable $callback
     * @param bool $recurse
     * @param string $path
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
     * Return whether or not an array has nested arrays.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function hasNested($array)
    {
        foreach ($array as $value) {
            if (is_array($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get array elements that are not null
     *
     * @param array $properties
     * @param array $allowed
     *
     * @return array
     */
    public static function filterNullValues($properties, array $allowed = null)
    {
        // If provided, only use allowed properties
        $properties = static::filterKeys($properties, $allowed);

        return array_filter(
            $properties,
            function ($value) {
                return !is_null($value);
            }
        );
    }

    /**
     * Filter the keys of an array to only the allowed set
     *
     * @param array $input
     * @param array $allowed
     *
     * @return array
     */
    public static function filterKeys($input, $allowed = [])
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
}
