<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Primitives\SpecialTypes;

/**
 * Class TypeHound
 *
 * Performs some meditation on the type of a value.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class TypeHound
{
    protected $value;

    protected $definitions;

    protected $compounds;

    protected $scalars;

    protected $specials;

    /**
     * Construct an instance of a TypeHound.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Register the internal type definitions used by this TypeHound.
     */
    protected function registerDefinitions()
    {
        $this->definitions = [
            new CompoundTypes(),
            new ScalarTypes(),
            new SpecialTypes(),
        ];
    }

    /**
     * Aggregate the all the types in the definitions.
     */
    protected function aggregateDefinitions()
    {
        array_map(function (TypesDefinition $definition) {
            $this->compounds = array_merge(
                $this->compounds,
                $definition->getCompounds()
            );

            $this->scalars = array_merge(
                $this->scalars,
                $definition->getScalars()
            );

            $this->specials = array_merge(
                $this->specials,
                $definition->getSpecial()
            );
        }, $this->definitions);
    }

    /**
     * Resolve the type name of the inner value.
     *
     * @return string
     * @throws UnknownTypeException
     */
    public function resolve()
    {
        if (is_scalar($this->value)) {
            if (is_string($this->value)) {
                return ScalarTypes::SCALAR_STRING;
            } elseif (is_bool($this->value)) {
                return ScalarTypes::SCALAR_BOOLEAN;
            } elseif (is_integer($this->value)) {
                return ScalarTypes::SCALAR_INTEGER;
            } elseif (is_float($this->value)) {
                return ScalarTypes::SCALAR_FLOAT;
            }
        } elseif (is_array($this->value)) {
            return CompoundTypes::COMPOUND_ARRAY;
        } elseif (is_object($this->value)) {
            return CompoundTypes::COMPOUND_OBJECT;
        } elseif (is_resource($this->value)) {
            return SpecialTypes::SPECIAL_RESOURCE;
        } elseif ($this->value === null) {
            return SpecialTypes::SPECIAL_NULL;
        }

        throw new UnknownTypeException(gettype($this->value));
    }

    // matches()

    // registerDefinition()

    // isKnown()

    /**
     * Creates a hound and resolves it immediately.
     *
     * @param mixed $value
     *
     * @return mixed
     * @throws UnknownTypeException
     */
    public static function createAndResolve($value)
    {
        return (new static($value))->resolve();
    }
}
