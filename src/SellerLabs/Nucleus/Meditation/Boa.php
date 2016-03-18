<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Foundation\BaseObject;
use SellerLabs\Nucleus\Meditation\Constraints\AbstractConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\AnyConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\ArrayOfConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\BooleanConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\CallableConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\ClosureConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\EitherConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\FoldableConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\FunctorConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\InArrayConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\LeftFoldableConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\LeftFoldableOfConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\ListConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\MapConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\MaybeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\NumericConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\ReadMapConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\CompoundTypes;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Meditation\Primitives\SpecialTypes;
use SellerLabs\Nucleus\Validation\Constraints\BetweenConstraint;
use Closure;

/**
 * Class Boa.
 *
 * Shortcuts for defining constraints.
 *
 *   Constriction is a method used by various snake species to kill their prey.
 *      - Wikipedia (2015)
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation
 */
class Boa extends BaseObject
{
    /**
     * @return AnyConstraint
     */
    public static function any()
    {
        return new AnyConstraint();
    }

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
     * @return ListConstraint
     */
    public static function lst()
    {
        return new ListConstraint();
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function object()
    {
        return new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_OBJECT);
    }

    /**
     * @return CallableConstraint
     */
    public static function func()
    {
        return new CallableConstraint();
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
     * @return MaybeConstraint
     */
    public static function maybeString()
    {
        return static::maybe(static::string());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeInteger()
    {
        return static::maybe(static::integer());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeBoolean()
    {
        return static::maybe(static::boolean());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeFloat()
    {
        return static::maybe(static::float());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeList()
    {
        return static::maybe(static::lst());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeArray()
    {
        return static::maybe(static::arr());
    }

    /**
     * @return MaybeConstraint
     */
    public static function maybeObject()
    {
        return static::maybe(static::object());
    }

    /**
     * @param string $of
     *
     * @return MaybeConstraint
     */
    public static function maybeInstance($of)
    {
        return static::maybe(static::instance($of));
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

    /**
     * @param Closure $closure
     * @param string|null $description
     *
     * @return ClosureConstraint
     */
    public static function inline(Closure $closure, $description = null)
    {
        return new ClosureConstraint($closure, $description);
    }

    /**
     * @return ReadMapConstraint
     */
    public static function readMap()
    {
        return new ReadMapConstraint();
    }

    /**
     * @return MapConstraint
     */
    public static function map()
    {
        return new MapConstraint();
    }

    /**
     * @return FoldableConstraint
     */
    public static function foldable()
    {
        return new FoldableConstraint();
    }

    /**
     * @return LeftFoldableConstraint
     */
    public static function leftFoldable()
    {
        return new LeftFoldableConstraint();
    }

    /**
     * @return LeftFoldableConstraint
     */
    public static function traversable()
    {
        return static::leftFoldable();
    }

    /**
     * @param AbstractConstraint $valueConstraint
     *
     * @return LeftFoldableOfConstraint
     */
    public static function traversableOf(AbstractConstraint $valueConstraint)
    {
        return static::leftFoldableOf($valueConstraint);
    }

    /**
     * @param AbstractConstraint $valueConstraint
     *
     * @return LeftFoldableOfConstraint
     */
    public static function leftFoldableOf(AbstractConstraint $valueConstraint)
    {
        return new LeftFoldableOfConstraint($valueConstraint);
    }

    /**
     * @param AbstractConstraint $valueConstraint
     *
     * @return ArrayOfConstraint
     */
    public static function arrOf(AbstractConstraint $valueConstraint)
    {
        return new ArrayOfConstraint($valueConstraint);
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function null()
    {
        return new PrimitiveTypeConstraint(
            SpecialTypes::SPECIAL_NULL
        );
    }

    /**
     * @return PrimitiveTypeConstraint
     */
    public static function resource()
    {
        return new PrimitiveTypeConstraint(
            SpecialTypes::SPECIAL_RESOURCE
        );
    }

    /**
     * @return FunctorConstraint
     */
    public static function functor()
    {
        return new FunctorConstraint();
    }

    /**
     * @return BooleanConstraint
     */
    public static function booleanLike()
    {
        return new BooleanConstraint();
    }

    /**
     * @return NumericConstraint
     */
    public static function numeric()
    {
        return new NumericConstraint();
    }
}
