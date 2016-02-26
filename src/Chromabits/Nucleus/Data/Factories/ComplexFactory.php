<?php

namespace Chromabits\Nucleus\Data\Factories;

use ArrayAccess;
use ArrayObject;
use Chromabits\Nucleus\Data\ArrayAccessMap;
use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\ReadMapInterface;
use Chromabits\Nucleus\Data\TraversableLeftFoldable;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\StaticObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Traversable;

/**
 * Class ComplexFactory
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Factories
 */
class ComplexFactory extends StaticObject
{
    /**
     * Wrap the provided value inside a LeftFoldable.
     *
     * @param array|ArrayObject|Traversable|LeftFoldableInterface $input
     *
     * @return ArrayList|TraversableLeftFoldable
     * @throws CoreException
     * @throws InvalidArgumentException
     */
    public static function toLeftFoldable($input)
    {
        Arguments::define(Boa::leftFoldable())->check($input);

        if ($input instanceof LeftFoldableInterface) {
            return $input;
        }

        if (is_array($input) || $input instanceof ArrayObject) {
            return static::toList($input);
        }

        if ($input instanceof Traversable) {
            return new TraversableLeftFoldable($input);
        }

        throw new CoreException('Unable to build LeftFoldable');
    }

    /**
     * Wrap the provided value inside a Functor.
     *
     * @param array|ArrayObject|Traversable|FunctorInterface $input
     *
     * @return ArrayList|TraversableLeftFoldable
     * @throws CoreException
     */
    public static function toFunctor($input)
    {
        Arguments::define(Boa::leftFoldable())->check($input);

        if ($input instanceof FunctorInterface) {
            return $input;
        }

        if (is_array($input) || $input instanceof ArrayObject) {
            return static::toList($input);
        }

        throw new CoreException('Unable to build Functor');
    }

    /**
     * Wrap provided value inside a List.
     *
     * @param array|ArrayObject|ListInterface $input
     *
     * @return ArrayList
     * @throws InvalidArgumentException
     */
    public static function toList($input)
    {
        Arguments::define(Boa::lst())->check($input);

        if ($input instanceof ListInterface) {
            return $input;
        }

        return ArrayList::of($input);
    }

    /**
     * Wrap provided value inside a Foldable.
     *
     * @param array|ArrayObject|FoldableInterface $input
     *
     * @return ArrayList
     * @throws CoreException
     * @throws InvalidArgumentException
     */
    public static function toFoldable($input)
    {
        Arguments::define(Boa::foldable())->check($input);

        if ($input instanceof FoldableInterface) {
            return $input;
        }

        if (is_array($input) || $input instanceof ArrayObject) {
            return static::toList($input);
        }

        throw new CoreException('Unable to build Foldable');
    }

    /**
     * Wrap the provided value inside a ReadMap.
     *
     * @param array|ArrayObject|ArrayAccess|Traversable|ReadMapInterface  $input
     *
     * @return ArrayAccessMap|ArrayList|TraversableLeftFoldable
     * @throws CoreException
     * @throws InvalidArgumentException
     */
    public static function toReadMap($input)
    {
        Arguments::define(Boa::readMap())->check($input);

        if ($input instanceof ReadMapInterface) {
            return $input;
        }

        if (is_array($input)
            || $input instanceof ArrayObject
            || $input instanceof ArrayAccess
        ) {
            return static::toMap($input);
        }

        if ($input instanceof Traversable) {
            return new TraversableLeftFoldable($input);
        }

        throw new CoreException('Unable to build ReadMap');
    }

    /**
     * Wrap the provided value inside a Map.
     *
     * @param array|ArrayObject|ArrayAccess|MapInterface $input
     *
     * @return ArrayAccessMap|ArrayList
     * @throws CoreException
     * @throws InvalidArgumentException
     */
    public static function toMap($input)
    {
        Arguments::define(Boa::map())->check($input);

        if ($input instanceof MapInterface) {
            return $input;
        }

        if (is_array($input) || $input instanceof ArrayObject) {
            return new ArrayMap($input);
        }

        if ($input instanceof ArrayAccess) {
            return new ArrayAccessMap($input);
        }

        throw new CoreException('Unable to build Map');
    }
}
