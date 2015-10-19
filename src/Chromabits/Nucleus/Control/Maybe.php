<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Closure;
use Mockery\Matcher\Not;

/**
 * Class MaybeMonad
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads
 */
abstract class Maybe extends Monad implements FunctorInterface, MonoidInterface
{
    /**
     * Nothing constructor.
     *
     * @return Maybe
     */
    public static function nothing()
    {
        return new Nothing(null);
    }

    /**
     * Just constructor.
     *
     * @param mixed $value
     *
     * @return Maybe
     */
    public static function just($value)
    {
        return new Just($value);
    }

    /**
     * @inheritDoc
     */
    public static function of($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        return static::just($value);
    }

    /**
     * >>==
     *
     * @param Closure $closure
     *
     * @return Maybe
     */
    public function bind(Closure $closure)
    {
        if ($this->isJust()) {
            return static::of($closure($this->value));
        }

        return static::nothing();
    }

    /**
     * Returns whether or not the contained value is in the form Just _.
     *
     * @return bool
     */
    abstract public function isJust();

    /**
     * Returns whether or not the contained value is Nothing.
     *
     * @return bool
     */
    abstract public function isNothing();

    /**
     * Extracts the element out of a Just.
     *
     * @param Maybe $maybe
     *
     * @return mixed
     * @throws InvalidArgumentException
     */
    public static function fromJust(Maybe $maybe)
    {
        if ($maybe->isNothing()) {
            throw new InvalidArgumentException();
        }

        return $maybe->value;
    }

    /**
     * The fromMaybe function takes a default value and and Maybe value.
     * If the Maybe is Nothing, it returns the default values; otherwise,
     * it returns the value contained in the Maybe.
     *
     * @param mixed $default
     * @param Maybe $maybe
     *
     * @return mixed
     */
    public static function fromMaybe($default, Maybe $maybe)
    {
        if ($maybe->isNothing()) {
            return $default;
        }

        return $maybe->value;
    }

    /**
     * @inheritDoc
     */
    public static function zero()
    {
        return static::nothing();
    }

    /**
     * @inheritDoc
     */
    public function append(SemigroupInterface $other, callable $callback)
    {
        // TODO: Implement append() method.
        throw new LackOfCoffeeException('Not implemented');
    }
}