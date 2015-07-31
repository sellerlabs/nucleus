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
 * Class SpecialTypes.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Primitives
 */
class SpecialTypes extends TypesDefinition
{
    const SPECIAL_RESOURCE = 'resource';
    const SPECIAL_NULL = 'null';

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
     * Get a list of names of all the special types defined.
     *
     * @return string[]
     */
    public function getSpecial()
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
            case static::SPECIAL_NULL:
                return $value === null;
            case static::SPECIAL_RESOURCE:
                return is_resource($value);
            default:
                return false;
        }
    }
}
