<?php

namespace Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Foundation\StaticObject;

/**
 * Class Json
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Json extends StaticObject
{
    /**
     * Placeholder.
     *
     * @param mixed $value
     * @param int $options
     * @param int $depth
     *
     * @return string
     */
    public static function encode($value, $options = 0, $depth = 512)
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
    public static function decode($value, $options = 0, $depth = 512)
    {
        return json_decode($value, true, $depth, $options);
    }
}
