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
 * Class ScalarTypes.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Primitives
 */
class ScalarTypes extends TypesDefinition
{
    const SCALAR_STRING = 'string';
    const SCALAR_INTEGER = 'integer';
    const SCALAR_FLOAT = 'float';
    const SCALAR_BOOLEAN = 'boolean';

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
     * Get a list of names of all the scalar types defined.
     *
     * @return string[]
     */
    public function getScalars()
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
            case static::SCALAR_STRING:
                return is_string($value);
            case static::SCALAR_INTEGER:
                return is_integer($value);
            case static::SCALAR_FLOAT:
                return is_float($value);
            case static::SCALAR_BOOLEAN:
                return is_bool($value);
            default:
                return false;
        }
    }
}
