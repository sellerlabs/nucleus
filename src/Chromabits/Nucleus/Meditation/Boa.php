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
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Constraints\BetweenConstraint;
use Chromabits\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\EitherConstraint;
use Chromabits\Nucleus\Meditation\Constraints\InArrayConstraint;
use Chromabits\Nucleus\Meditation\Constraints\MaybeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;

/**
 * Class Boa.
 *
 * Shortcuts for defining constraints.
 *
 *   Constriction is a method used by various snake species to kill their prey.
 *      - Wikipedia (2015)
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class Boa extends BaseObject
{
    /**
     * @return PrimitiveTypeConstraint
     */
    public static function string()
    {
        return new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function integer()
    {
        return new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function float()
    {
        return new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function boolean()
    {
        return new PrimitiveTypeConstraint(ScalarTypes::SCALAR_BOOLEAN);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function arr()
    {
        return new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function object()
    {
        return new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_OBJECT);
    }

    /**
     * @param AbstractConstraint $one
     * @param AbstractConstraint $other
     *
     * @return EitherConstraint
     */
    public static function either(
        AbstractConstraint $one,
        AbstractConstraint $other
    ) {
        return new EitherConstraint($one, $other);
    }

    /**
     * @param AbstractConstraint $one
     *
     * @return MaybeConstraint
     */
    public static function maybe(AbstractConstraint $one)
    {
        return new MaybeConstraint($one);
    }

    /**
     * @param string $className
     *
     * @return ClassTypeConstraint
     */
    public static function instance($className)
    {
        return new ClassTypeConstraint($className);
    }

    /**
     * @param int|float $min
     * @param int|float $max
     *
     * @return BetweenConstraint
     */
    public static function between($min, $max)
    {
        return new BetweenConstraint($min, $max);
    }

    /**
     * @param array $allowed
     *
     * @return InArrayConstraint
     */
    public static function in(array $allowed)
    {
        return new InArrayConstraint($allowed);
    }
}
