<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Strings;

use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class Rope.
 *
 * Like a string, but better.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Strings
 */
class Rope extends BaseObject
{
    protected $contents;

    protected $encoding;

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
     * Replace the snake case cache.
     *
     * @param string[] $cache
     */
    public static function setSnakeCache($cache)
    {
        static::$snakeCache = $cache;
    }

    /**
     * Replace the camel case cache.
     *
     * @param string[] $cache
     */
    public static function setCamelCache($cache)
    {
        static::$camelCache = $cache;
    }

    /**
     * Replace the studly cache.
     *
     * @param string[] $cache
     */
    public static function setStudlyCache($cache)
    {
        static::$studlyCache = $cache;
    }

    /**
     * Construct an instance of a Rope.
     *
     * @param string $contents
     * @param null $encoding
     */
    public function __construct($contents = '', $encoding = null)
    {
        parent::__construct();

        $this->contents = (string) $contents;
        $this->encoding = coalesce($encoding, mb_internal_encoding());
    }

    /**
     * Get the primitive string version of this Rope.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->contents;
    }

    /**
     * Get the primitive string version of this Rope.
     *
     * @return string
     */
    public function toString()
    {
        return $this->contents;
    }

    /**
     * Convert a value to camel case.
     *
     * @return Rope
     */
    public function toCamel()
    {
        $hash = md5($this->contents);

        if (isset(static::$camelCache[$hash])) {
            return new static(static::$camelCache[$hash], $this->encoding);
        }

        return new static(
            static::$camelCache[$hash] = mb_lcfirst(
                $this->toStudly(),
                $this->encoding
            ),
            $this->encoding
        );
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $delimiter
     * @return Rope
     */
    public function toSnake($delimiter = '_')
    {
        $hash = md5($this->contents) . $delimiter;

        if (isset(static::$snakeCache[$hash])) {
            return new static(static::$snakeCache[$hash], $this->encoding);
        }

        $value = $this->contents;

        if (!mb_ctype_lower($value, $this->encoding)) {
            // Set the target encoding.
            $previous = mb_regex_encoding();
            mb_regex_encoding($this->encoding);

            $value = mb_strtolower(preg_replace(
                '/(.)(?=[A-Z])/u',
                '$1' . $delimiter,
                $value
            ), $this->encoding);

            // Restore the previous encoding.
            mb_regex_encoding($previous);
        }

        return new static(
            static::$snakeCache[$value . $delimiter] = $value,
            $this->encoding
        );
    }

    /**
     * Convert a value to studly caps case.
     *
     * @return Rope
     */
    public function toStudly()
    {
        $hash = md5($this->contents);

        if (isset(static::$studlyCache[$hash])) {
            return new static(static::$studlyCache[$hash], $this->encoding);
        }

        $value = mb_ucwords(
            str_replace(['-', '_'], ' ', $this->contents),
            $this->encoding
        );

        return new static(
            static::$studlyCache[$hash] = str_replace(' ', '', $value),
            $this->encoding
        );
    }
}
