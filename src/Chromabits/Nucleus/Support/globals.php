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
     * @param integer|float $min
     * @param integer|float $max
     * @param integer|float $value
     *
     * @return bool
     * @throws LackOfCoffeeException
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
     * @return null
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
     * @return null
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
        return Std::escapeHtml($string);
    }
}

if (!function_exists('mb_lcfirst')) {
    /**
     * Multi-byte version of lcfirst().
     *
     * @param string $str
     * @param null|string $encoding
     *
     * @return string
     */
    function mb_lcfirst($str, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        $first = mb_strtolower(
            mb_substr($str, 0, 1, $encoding),
            $encoding
        );

        return $first . mb_substr($str, 1, null, $encoding);
    }
}

if (!function_exists('mb_ucfirst')) {
    /**
     * Multi-byte version of ucfirst().
     *
     * @param string $str
     * @param null|string $encoding
     *
     * @return string
     */
    function mb_ucfirst($str, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        $first = mb_strtoupper(
            mb_substr($str, 0, 1, $encoding),
            $encoding
        );

        return $first . mb_substr($str, 1, null, $encoding);
    }
}

if (!function_exists('mb_ctype_lower')) {
    /**
     * Multi-byte version of ctype_lower().
     *
     * @param string $text
     * @param null|string $encoding
     *
     * @return bool
     */
    function mb_ctype_lower($text, $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());
        $characters = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($characters as $char) {
            if (mb_strtolower($char, $encoding) != $char) {
                return false;
            }
        }

        return true;
    }
}

if (!function_exists('mb_ucwords')) {
    /**
     * Multibyte version of ucwords().
     *
     * @param string $str
     * @param string $delimiters
     * @param null|string $encoding
     *
     * @return mixed|string
     */
    function mb_ucwords($str, $delimiters = '', $encoding = null)
    {
        $encoding = coalesce($encoding, mb_internal_encoding());

        if (is_string($delimiters)) {
            $delimiters = str_split(str_replace(' ', '', $delimiters));
        }

        $firstPattern = [];
        $firstReplace = [];
        $secondPattern = [];
        $secondReplace = [];

        foreach ($delimiters as $delimiter) {
            $id = uniqid();
            $firstPattern[] = '/' . preg_quote($delimiter) . '/';
            $firstReplace[] = $delimiter . $id . ' ';
            $secondPattern[] = '/' . preg_quote($delimiter . $id . ' ') . '/';
            $secondReplace[] = $delimiter;
        }

        $result = preg_replace($firstPattern, $firstReplace, $str);

        $words = explode(' ', $result);

        foreach ($words as $index => $word) {
            $words[$index] = mb_ucfirst($word, $encoding);
        }

        $result = implode(' ', $words);

        $result = preg_replace($secondPattern, $secondReplace, $result);

        return $result;
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
