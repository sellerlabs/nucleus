<?php

namespace Chromabits\Nucleus\Support;

use RuntimeException;

/**
 * Class Str
 *
 * String utilities (from Laravel)
 *
 * @package Chromabits\TutumClient\Support
 */
class Str
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * Convert a value to camel case.
     *
     * @param string $value
     * @return string
     */
    public static function camel($value)
    {
        if (isset(static::$camelCache[$value]))
        {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        if (isset(static::$snakeCache[$value.$delimiter]))
        {
            return static::$snakeCache[$value.$delimiter];
        }

        if ( ! ctype_lower($value))
        {
            $value = strtolower(preg_replace('/(.)(?=[A-Z])/', '$1'.$delimiter, $value));
        }

        return static::$snakeCache[$value.$delimiter] = $value;
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     * @return string
     */
    public static function studly($value)
    {
        if (isset(static::$studlyCache[$value]))
        {
            return static::$studlyCache[$value];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$value] = str_replace(' ', '', $value);
    }

    /**
     * Replace the snake case cache
     *
     * @param $cache
     */
    public static function setSnakeCache($cache)
    {
        static::$snakeCache = $cache;
    }

    /**
     * Replace the camel case cache
     *
     * @param $cache
     */
    public static function setCamelCache($cache)
    {
        static::$camelCache = $cache;
    }

    /**
     * Replace the studly cache
     *
     * @param $cache
     */
    public static function setStudlyCache($cache)
    {
        static::$studlyCache = $cache;
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param  int $length
     *
     * @return string
     * @throws \RuntimeException
     */
    public static function random($length = 16)
    {
        if ( ! function_exists('openssl_random_pseudo_bytes'))
        {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false)
        {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $length);
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param  int  $length
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
