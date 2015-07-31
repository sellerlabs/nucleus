<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation\Primitives;

use Chromabits\Nucleus\Meditation\TypesDefinition;

/**
 * Class CompoundTypes.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Primitives
 */
class CompoundTypes extends TypesDefinition
{
    const COMPOUND_ARRAY = 'array';
    const COMPOUND_OBJECT = 'object';

    /**
     * Get a list of names of all the types defined.
     *
     * @return string[]
     */
    public function getTypesDefined()
    {
        return $this->getValues();
    }

    /**
     * Get a list of names of all the compound types defined.
     *
     * @return string[]
     */
    public function getCompounds()
    {
        return $this->getValues();
    }

    /**
     * Type check a value.
     *
     * @param string $typeName
     * @param mixed $value
     *
     * @return bool
     */
    public function check($typeName, $value)
    {
        switch ($typeName) {
            case static::COMPOUND_ARRAY:
                return is_array($value);
            case static::COMPOUND_OBJECT:
                return is_object($value);
            default:
                return false;
        }
    }
}
