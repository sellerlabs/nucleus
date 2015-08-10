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

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Strings\Rope;
use RuntimeException;

/**
 * Class Str.
 *
 * Some string utilities (from Laravel)
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Str extends BaseObject
{
    /**
     * Convert a value to camel case.
     *
     * @param string $value
     * @param string|null $encoding
     *
     * @return string
     */
    public static function camel($value, $encoding = null)
    {
        return (new Rope($value, $encoding))->toCamel()->toString();
    }

    /**
     * Convert a string to snake case.
     *
     * @param string $value
     * @param string $delimiter
     * @param string|null $encoding
     *
     * @return string
     */
    public static function snake($value, $delimiter = '_', $encoding = null)
    {
        return (new Rope($value, $encoding))->toSnake($delimiter)->toString();
    }

    /**
     * Convert a value to studly caps case.
     *
     * @param string $value
     * @param string|null $encoding
     *
     * @return string
     */
    public static function studly($value, $encoding = null)
    {
        return (new Rope($value, $encoding))->toStudly()->toString();
    }

    /**
     * Generate a more truly "random" alpha-numeric string.
     *
     * @param integer $length
     *
     * @throws RuntimeException
     * @return string
     */
    public static function random($length = 16)
    {
        if (!function_exists('openssl_random_pseudo_bytes')) {
            throw new RuntimeException('OpenSSL extension is required.');
        }

        $bytes = openssl_random_pseudo_bytes($length * 2);

        if ($bytes === false) {
            throw new RuntimeException('Unable to generate random string.');
        }

        return substr(
            str_replace(['/', '+', '='], '', base64_encode($bytes)),
            0,
            $length
        );
    }

    /**
     * Generate a "random" alpha-numeric string.
     *
     * Should not be considered sufficient for cryptography, etc.
     *
     * @param integer $length
     * @return string
     */
    public static function quickRandom($length = 16)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
