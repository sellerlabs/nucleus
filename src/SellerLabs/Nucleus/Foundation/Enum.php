<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Foundation;

use SellerLabs\Nucleus\Data\ArrayList;
use SellerLabs\Nucleus\Data\ArrayMap;
use SellerLabs\Nucleus\Data\Interfaces\ListInterface;
use SellerLabs\Nucleus\Data\Interfaces\MapInterface;
use ReflectionClass;

/**
 * Class Enum.
 *
 * An enumeration emulation.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Foundation
 */
abstract class Enum extends BaseObject
{
    /**
     * Get the names of possible constants in the enumeration.
     *
     * @return array
     */
    public static function getKeys()
    {
        return ArrayList::of(static::getValues())->toArray();
    }

    /**
     * Get the value of all constants in the enumeration.
     *
     * @return array
     */
    public static function getValues()
    {
        $self = new ReflectionClass(static::class);

        return $self->getConstants();
    }

    /**
     * @return MapInterface
     */
    public static function toMap()
    {
        return ArrayMap::of(static::getValues());
    }

    /**
     * @return ListInterface
     */
    public static function toList()
    {
        return ArrayList::of(static::getValues());
    }

    /**
     * @return ListInterface
     */
    public static function toValuesList()
    {
        return ArrayMap::of(static::getValues())->values();
    }
}
