<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Support\Enum;

/**
 * Class TypesDefinition
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
     * @return boolean
     */
    abstract public function check($typeName, $value);

    /**
     * Throw an UnknownTypeException with the provided type.
     *
     * @param string $typeName
     *
     * @throws UnknownTypeException
     */
    protected function throwUnknownTypeException($typeName)
    {
        throw new UnknownTypeException($typeName);
    }
}
