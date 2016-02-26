<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Foundation\Enum;

/**
 * Class TypesDefinition.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
abstract class TypesDefinition extends Enum
{
    /**
     * Get a list of names of all the types defined.
     *
     * @return string[]
     */
    abstract public function getTypesDefined();

    /**
     * Get a list of names of all the scalar types defined.
     *
     * @return string[]
     */
    public function getScalars()
    {
        return [];
    }

    /**
     * Get a list of names of all the compound types defined.
     *
     * @return string[]
     */
    public function getCompounds()
    {
        return [];
    }

    /**
     * Get a list of names of all the special types defined.
     *
     * @return string[]
     */
    public function getSpecial()
    {
        return [];
    }

    /**
     * Type check a value.
     *
     * @param string $typeName
     * @param mixed $value
     *
     * @return bool
     */
    abstract public function check($typeName, $value);
}
