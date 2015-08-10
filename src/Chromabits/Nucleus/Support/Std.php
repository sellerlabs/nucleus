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
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\Strings\Rope;
use Closure;
use ReflectionFunction;
use Traversable;

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
     * Applies function fn to the argument list args. This is useful for
     * creating a fixed-arity function from a variadic function. fn should be a
     * bound function if context is significant. (From Ramda)
     *
     * @param callable $function
     * @param array|Traversable $args
     *
     * @return mixed
     */
    public static function apply(callable $function, $args)
    {
        Arguments::contain(Boa::func(), Boa::lst())->check($function, $args);

        return Std::call($function, ...$args);
    }

    /**
     * Call the first argument with the remaining arguments.
     *
     * @param callable $function
     * @param mixed ...$args
     *
     * @return mixed
     */
    public static function call(callable $function, ...$args)
    {
        return call_user_func($function, ...$args);
    }

    /**
     * Concatenate the two provided values.
     *
     * @param string|array|Traversable $one
     * @param string|array|Traversable $two
     *
     * @return mixed
     * @throws MismatchedArgumentTypesException
     * @throws InvalidArgumentException
     */
    public static function concat($one, $two)
    {
        Arguments::contain(
            Boa::either(
                Boa::lst(),
                Boa::string()
            ),
            Boa::either(
                Boa::lst(),
                Boa::string()
            )
        )->check($one, $two);

        $oneType = TypeHound::fetch($one);
        $twoType = TypeHound::fetch($two);

        if ($oneType !== $twoType) {
            throw new MismatchedArgumentTypesException(
                __FUNCTION__,
                $one,
                $two
            );
        }

        if ($oneType === ScalarTypes::SCALAR_STRING) {
            return $one . $two;
        }

        return array_merge($one, $two);
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
     * Returns a single item by iterating through the list, successively calling
     * the iterator function and passing it an accumulator value and the current
     * value from the array, and then passing the result to the next call.
     * (From Ramda)
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|Traversable $list
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function reduce(callable $function, $initial, $list)
    {
        Arguments::contain(Boa::func(), Boa::any(), Boa::lst())
            ->check($function, $initial, $list);

        return array_reduce($list, $function, $initial);
    }

    /**
     * Same as reduce but it works from right to left.
     *
     * @param callable $function
     * @param mixed $initial
     * @param array|Traversable $list
     *
     * @return mixed
     */
    public static function reduceRight(callable $function, $initial, $list)
    {
        return static::reduce($function, $initial, static::reverse($list));
    }

    /**
     * Return the input array but with its items reversed.
     *
     * @param array|Traversable $input
     *
     * @return array
     */
    public static function reverse($input)
    {
        Arguments::contain(Boa::lst())->check($input);

        return array_reverse($input);
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
        return json_decode($value, true, $depth, $options);
    }

    /**
     * Call a function on every itme in a list and return the resulting list.
     *
     * @param callable $function
     * @param array|Traversable $list
     *
     * @return array
     */
    public static function map(callable $function, $list)
    {
        Arguments::contain(Boa::func(), Boa::lst())->check($function, $list);

        // Optimization, use array_map for arrays.
        if (is_array($list)) {
            return array_map($function, $list, array_keys($list));
        }

        $aggregation = [];

        foreach ($list as $key => $value) {
            $aggregation[$key] = $function($value, $key);
        }

        return $aggregation;
    }

    /**
     * Filter a list by calling a callback on each element.
     *
     * If the callback returns true, then the element will be added to the
     * resulting array. Otherwise, it will be skipped.
     *
     * Also, unlike array_filter, this function preserves indexes.
     *
     * @param callable $function
     * @param array|Traversable $list
     *
     * @return array
     */
    public static function filter(callable $function, $list)
    {
        Arguments::contain(Boa::func(), Boa::lst())->check($function, $list);

        $aggregation = [];

        foreach ($list as $key => $value) {
            if ($function($value, $key)) {
                $aggregation[$key] = $value;
            }
        }

        return $aggregation;
    }

    /**
     * Left-curry the provided function.
     *
     * @param callable $function
     * @param mixed ...$args
     *
     * @return Closure|mixed
     */
    public static function curry(callable $function, ...$args)
    {
        return static::curryArgs($function, $args);
    }

    /**
     * Left-curry the provided function with the provided arry of arguments.
     *
     * @param callable $function
     * @param mixed[] $args
     *
     * @return Closure|mixed
     */
    public static function curryArgs(callable $function, $args)
    {
        // Counts required parameters.
        $required = function () use ($function, $args) {
            return (new ReflectionFunction($function))
                ->getNumberOfRequiredParameters();
        };

        $isFulfilled = function (callable $function, $args) use ($required) {
            return count($args) >= $required($function);
        };

        if ($isFulfilled($function, $args)) {
            return static::apply($function, $args);
        }

        return function (...$funcArgs) use (
            $function,
            $args,
            $required,
            $isFulfilled
        ) {
            $newArgs = array_merge($args, $funcArgs);
            print_r($newArgs);

            if ($isFulfilled($function, $newArgs)) {
                return static::apply($function, $newArgs);
            }

            return static::curryArgs($function, $newArgs);
        };
    }
}
