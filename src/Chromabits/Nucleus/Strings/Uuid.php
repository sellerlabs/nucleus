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
 * Class Uuid.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Strings
 */
class Uuid extends BaseObject
{
    /**
     * Generates a v4 UUID from data.
     *
     * @param string $data
     *
     * @return string
     */
    public static function v4FromData($data)
    {
        assert(strlen($data) == 16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * Generates a random v4 UUID.
     *
     * @return string
     */
    public static function v4()
    {
        return static::v4FromData(openssl_random_pseudo_bytes(16));
    }

    /**
     * Check if the input string is a valid v4 UUID.
     *
     * @param string $input
     *
     * @return bool
     */
    public static function validV4($input)
    {
        return preg_match(
            '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]'
            . '{3}-[0-9a-f]{12}$/',
            $input
        ) === 1;
    }
}
