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

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Primitives\SpecialTypes;

/**
 * Class TypeHound.
 *
 * Performs some meditation on the type of a value.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class TypeHound extends BaseObject
{
    /**
     * The value being examined.
     *
     * @var mixed
     */
    protected $value;

    /**
     * The types defined.
     *
     * @var string[]
     */
    protected static $types = [];

    /**
     * @var TypesDefinition[]
     */
    protected static $definitions = [];

    /**
     * @var string[]
     */
    protected static $compounds = [];

    /**
     * @var string[]
     */
    protected static $scalars = [];

    /**
     * @var string[]
     */
    protected static $specials = [];

    /**
     * Construct an instance of a TypeHound.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct();

        $this->value = $value;
    }

    /**
     * Register the internal type definitions used by this TypeHound.
     */
    protected static function registerDefinitions()
    {
        static::$definitions = [
            new CompoundTypes(),
            new ScalarTypes(),
            new SpecialTypes(),
        ];
    }

    /**
     * Aggregate the all the types in the definitions.
     */
    protected static function aggregateDefinitions()
    {
        array_map(function (TypesDefinition $definition) {
            static::$compounds = array_merge(
                static::$compounds,
                $definition->getCompounds()
            );

            static::$scalars = array_merge(
                static::$scalars,
                $definition->getScalars()
            );

            static::$specials = array_merge(
                static::$specials,
                $definition->getSpecial()
            );

            static::$types = array_merge(
                static::$types,
                $definition->getCompounds(),
                $definition->getScalars(),
                $definition->getSpecial()
            );
        }, static::$definitions);
    }

    /**
     * Resolve the type name of the inner value.
     *
     * @throws UnknownTypeException
     * @return string
     */
    public function resolve()
    {
        // TODO: Make this dynamic.

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

    /**
     * Check that the type matches.
     *
     * @param TypeHound $other
     *
     * @throws UnknownTypeException
     * @return bool
     */
    public function matches(TypeHound $other)
    {
        return $this->resolve() === $other->resolve();
    }

    /**
     * Check if the type is known.
     *
     * @param string $typeName
     *
     * @return bool
     */
    public static function isKnown($typeName)
    {
        static::registerDefinitions();
        static::aggregateDefinitions();

        return in_array($typeName, static::$types);
    }

    /**
     * Creates a hound and resolves it immediately.
     *
     * @param mixed $value
     *
     * @deprecated
     * @throws UnknownTypeException
     * @return mixed
     */
    public static function createAndResolve($value)
    {
        return static::fetch($value);
    }

    /**
     * Creates a hound and resolves it immediately.
     *
     * @param mixed $value
     *
     * @throws UnknownTypeException
     * @return mixed
     */
    public static function fetch($value)
    {
        return (new static($value))->resolve();
    }
}
