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

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\ListableInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\MappableInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Std;
use Closure;

/**
 * Class Rope.
 *
 * Like a string, but better.
 *
 * - Rope is a wrapper of a PHP string.
 * - Most operations should be safe for international strings.
 * - Operations are immutable; They will return a new instance of a Rope.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Strings
 */
class Rope extends BaseObject implements
    FunctorInterface,
    MonoidInterface,
    ListableInterface,
    MappableInterface
{
    const ENCODING_UTF8 = 'UTF-8';

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
     * Internal string.
     *
     * @var string
     */
    protected $contents;

    /**
     * Name of the encoding to use.
     *
     * @var string
     */
    protected $encoding;

    /**
     * Construct an instance of a Rope.
     *
     * @param string|Rope $contents
     * @param string|null $encoding
     */
    public function __construct($contents = '', $encoding = null)
    {
        parent::__construct();

        $this->contents = (string) $contents;
        $this->encoding = Std::coalesce($encoding, mb_internal_encoding());
    }

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
     * Get an empty monoid.
     *
     * @return Rope
     */
    public static function zero()
    {
        return static::of();
    }

    /**
     * Get the encoding used for this Rope.
     *
     * @return string
     */
    public function getEncoding()
    {
        return $this->encoding;
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
            " \t\r\n\f\v",
            $this->encoding
        );

        return new static(
            static::$studlyCache[$hash] = str_replace(' ', '', $value),
            $this->encoding
        );
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $delimiter
     *
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
            ),
                $this->encoding);

            // Restore the previous encoding.
            mb_regex_encoding($previous);
        }

        return new static(
            static::$snakeCache[$value . $delimiter] = $value,
            $this->encoding
        );
    }

    /**
     * Get this Rope with all its characters in lowercase.
     *
     * @return Rope
     */
    public function toLower()
    {
        return static::of(mb_strtolower(
            $this->contents,
            $this->encoding
        ), $this->encoding);
    }

    /**
     * Get this Rope with all its characters in uppercase.
     *
     * @return Rope
     */
    public function toUpper()
    {
        return static::of(mb_strtoupper(
            $this->contents,
            $this->encoding
        ), $this->encoding);
    }

    /**
     * Get the string with the first character in lower-case.
     *
     * @return Rope
     */
    public function lowerFirst()
    {
        return static::of(
            mb_lcfirst($this->contents, $this->encoding),
            $this->encoding
        );
    }

    /**
     * Construct an instance of a Rope.
     *
     * @param string|Rope $contents
     * @param string|null $encoding
     *
     * @return Rope
     */
    public static function of($contents = '', $encoding = null)
    {
        if ($contents instanceof Rope) {
            return $contents;
        }

        return new static($contents, $encoding);
    }

    /**
     * Get the string with the first character in upper-case.
     *
     * @return Rope
     */
    public function upperFirst()
    {
        return static::of(
            mb_ucfirst($this->contents, $this->encoding),
            $this->encoding
        );
    }

    /**
     * Returns true if all the characters in the string are lower-case.
     *
     * @return bool
     */
    public function isLower()
    {
        return mb_ctype_lower($this->contents, $this->encoding);
    }

    /**
     * Return the string with all the words in upper case.
     *
     * Delimiters are used to determine what is a word.
     *
     * @param string $delimiters
     *
     * @return Rope
     */
    public function upperWords($delimiters = " \t\r\n\f\v")
    {
        return static::of(
            mb_ucwords($this->contents, $delimiters, $this->encoding),
            $this->encoding
        );
    }

    /**
     * Get the length of the string.
     *
     * @return int
     */
    public function length()
    {
        return mb_strlen($this->contents, $this->encoding);
    }

    /**
     * Trim characters at the ends of the string.
     *
     * @param string $characterMask
     *
     * @return Rope
     */
    public function trim($characterMask = " \t\n\r\0\x0B")
    {
        return static::of(
            trim($this->contents, $characterMask),
            $this->encoding
        );
    }

    /**
     * Returns true if the string begins with the provided string.
     *
     * @param string|Rope $prefix
     *
     * @return bool
     */
    public function beginsWith($prefix)
    {
        return $prefix === ''
        || mb_strpos(
            $this->contents,
            (string) $prefix,
            null,
            $this->encoding
        ) === 0;
    }

    /**
     * Returns true if the string ends with the provided string.
     *
     * @param string|Rope $suffix
     *
     * @return bool
     */
    public function endsWith($suffix)
    {
        return $suffix === ''
        || $suffix === mb_substr(
            $this->contents,
            -strlen((string) $suffix),
            null,
            $this->encoding
        );
    }

    /**
     * Returns true if the string contains the provided string.
     *
     * @param string|Rope $inner
     *
     * @return bool
     */
    public function contains($inner)
    {
        return mb_strpos(
            $this->contents,
            (string) $inner,
            null,
            $this->encoding
        ) !== false;
    }

    /**
     * Return the string with all its characters reversed.
     *
     * @return Rope
     */
    public function reverse()
    {
        return static::of(
            ArrayList::of($this->split())->reverse()->join(),
            $this->encoding
        );
    }

    /**
     * Split the string into smaller chunks.
     *
     * @param int $splitLength
     *
     * @return string[]
     * @throws \Exception
     */
    public function split($splitLength = 1)
    {
        return mb_str_split($this->contents, $splitLength, $this->encoding);
    }

    /**
     * Get Rope containing the same string but use a different encoding.
     *
     * @param string $encoding
     *
     * @return Rope
     */
    public function toEncoding($encoding)
    {
        return static::of($this->toString(), $encoding);
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
     * Apply a function to this functor.
     *
     * @param callable|Closure $closure
     *
     * @return FunctorInterface
     */
    public function fmap(callable $closure)
    {
        return $this->toList()->fmap($closure);
    }

    /**
     * Get a List containing the characters of this string.
     *
     * @return ArrayList
     */
    public function toList()
    {
        return new ArrayList($this->split());
    }

    /**
     * Append another semigroup and return the result.
     *
     * @param Rope|SemigroupInterface $other
     *
     * @return Rope
     */
    public function append(SemigroupInterface $other)
    {
        return $this->concat($other);
    }

    /**
     * Concatenate with other strings.
     *
     * @param array<string|Rope> ...$others
     *
     * @return Rope
     */
    public function concat(...$others)
    {
        return static::of(
            Std::foldl(
                function ($carry, $part) {
                    return $carry . (string) $part;
                },
                $this->contents,
                $others
            ),
            $this->encoding
        );
    }

    /**
     * @return ArrayMap
     */
    public function toMap()
    {
        return new ArrayMap($this->split());
    }

    /**
     * Return whether this Rope is equal to another.
     *
     * @param Rope $other
     *
     * @return bool
     */
    public function equals(Rope $other)
    {
        return $this->contents === $other->contents
            && $this->encoding === $other->encoding;
    }
}
