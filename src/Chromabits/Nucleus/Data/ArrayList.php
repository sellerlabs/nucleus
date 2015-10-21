<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;
use Chromabits\Nucleus\Support\Std;
use Closure;

/**
 * Class ArrayList
 *
 * An implementation of a List backed by an array.
 *
 * This is an early WIP. Interfaces might change over time.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
class ArrayList implements MonoidInterface, FoldableInterface, LeftFoldableInterface
{
    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ArrayList.
     *
     * @param array $initial
     */
    public function __construct(array $initial = [])
    {
        $this->value = $initial;
    }

    /**
     * Append another semigroup and return the result.
     *
     * @param SemigroupInterface $other
     *
     * @return SemigroupInterface
     * @throws CoreException
     * @throws MismatchedArgumentTypesException
     */
    public function append(SemigroupInterface $other)
    {
        if (!$other instanceof static) {
            throw new CoreException(
                'ArrayList can only be appended by another ArrayList.'
            );
        }

        return new static(Std::concat(
            $this->value,
            $other->value
        ));
    }

    /**
     * Get an empty monoid.
     *
     * @return MonoidInterface
     */
    public static function zero()
    {
        return new static();
    }

    /**
     * Apply a function to this functor.
     *
     * @param callable $closure
     *
     * @return FunctorInterface
     */
    public function fmap(callable $closure)
    {
        return Std::map($closure, $this->value);
    }

    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldr(callable $closure, $initial)
    {
        return new static(
            Std::foldr($closure, $initial, $this->value)
        );
    }

    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldl(callable $closure, $initial)
    {
        return new static(
            Std::foldl($closure, $initial, $this->value)
        );
    }
}
