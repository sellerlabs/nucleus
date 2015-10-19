<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Closure;

/**
 * Class MaybeMonad
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads
 */
class Maybe extends Monad implements FunctorInterface
{
    /**
     * Nothing constructor.
     *
     * @return Maybe
     */
    public static function nothing()
    {
        return static::of(null);
    }

    /**
     * Just constructor.
     *
     * @param mixed $value
     *
     * @return Maybe
     * @throws InvalidArgumentException
     */
    public static function just($value)
    {
        if ($value === null) {
            throw new InvalidArgumentException(
                'You are providing a null to a Just constructor. Consider ' .
                'revising your application logic so that the value passed ' .
                'to the constructor is never null, or use the Nothing ' .
                'constructor.'
            );
        }

        return static::of($value);
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
    public function isJust()
    {
        return $this->value !== null;
    }

    /**
     * Returns whether or not the contained value is Nothing.
     *
     * @return bool
     */
    public function isNothing()
    {
        return $this->value === null;
    }

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
}