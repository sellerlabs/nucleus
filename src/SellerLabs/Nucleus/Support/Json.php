<?php

namespace SellerLabs\Nucleus\Support;

use SellerLabs\Nucleus\Foundation\StaticObject;

/**
 * Class Json
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Support
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
