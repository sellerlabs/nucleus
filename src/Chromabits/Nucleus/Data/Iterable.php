<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\IterableInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Foundation\Interfaces\ArrayableInterface;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class Iterable.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
abstract class Iterable extends BaseObject implements
    ArrayableInterface,
    FunctorInterface,
    FoldableInterface,
    IterableInterface
{
    /**
     * @var int
     */
    protected $size;

    /**
     * @return AbstractTypeConstraint
     */
    abstract public function getKeyType();

    /**
     * @return AbstractTypeConstraint
     */
    abstract public function getValueType();

    /**
     * @param mixed $key
     *
     * @return Maybe
     */
    abstract public function lookup($key);

    /**
     * @param mixed $key
     *
     * @return bool
     */
    abstract public function member($key);

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function includes($value)
    {
        return $this->find(function ($current) use ($value) {
            return $current === $value;
        })->isJust();
    }

    /**
     * @return mixed
     */
    public function head()
    {
        return Maybe::fromJust($this->lookup(0));
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return Maybe::fromJust($this->lookup($this->size - 1));
    }

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return Maybe
     */
    abstract public function lookupIn($searchKeyPath);

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return mixed
     */
    abstract public function memberIn($searchKeyPath);

    /**
     * @return array
     */
    abstract public function toArray();

    /**
     * @param callable $callable
     *
     * @return Iterable
     */
    abstract public function fmap(callable $callable);

    /**
     * @param callable $callable
     *
     * @return static|Iterable
     */
    public function map(callable $callable)
    {
        return $this->fmap($callable);
    }

    /**
     * @param callable $callable
     *
     * @return Iterable
     */
    abstract public function filter(callable $callable);

    /**
     * @param callable $callable
     *
     * @return Iterable
     */
    public function filterNot(callable $callable)
    {
        return $this->filter(
            function ($value, $key, $iterable) use ($callable) {
                return !$callable($value, $key, $iterable);
            }
        );
    }

    /**
     * @return Iterable
     */
    abstract public function reverse();

    /**
     * @param callable $comparator
     *
     * @return Iterable
     */
    abstract public function sort(callable $comparator = null);

    /**
     * @param callable $comparatorValueMapper
     * @param callable|null $comparator
     *
     * @return Iterable
     */
    public function sortBy(
        callable $comparatorValueMapper,
        callable $comparator = null
    ) {
        return $this->map($comparatorValueMapper)->sort($comparator);
    }

    /**
     * @param callable $sideEffect
     *
     * @return int
     */
    abstract public function each(callable $sideEffect);

    /**
     * @param int $begin
     * @param int|null $end
     *
     * @return Iterable
     */
    abstract public function slice($begin, $end = null);

    /**
     * @return Iterable
     */
    public function tail()
    {
        return $this->slice(1);
    }

    /**
     * @return Iterable
     */
    public function init()
    {
        return $this->slice(0, -1);
    }

    /**
     * @param int $amount
     *
     * @return Iterable
     */
    public function take($amount)
    {
        // Optimization.
        if ($amount >= $this->size) {
            return $this;
        }

        return $this->slice(0, $amount);
    }

    /**
     * @param int $amount
     *
     * @return Iterable
     */
    public function takeLast($amount)
    {
        return $this->reverse()->take($amount);
    }

    /**
     * @param callable $predicate
     *
     * @return Iterable
     */
    abstract public function takeWhile(callable $predicate);

    /**
     * @param callable $predicate
     *
     * @return Iterable
     */
    public function takeUntil(callable $predicate)
    {
        return $this->takeWhile(
            function ($value, $key, $iterable) use ($predicate) {
                return !$predicate($value, $key, $iterable);
            }
        );
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    /**
     * @param callable $predicate
     *
     * @return Maybe
     */
    public function find(callable $predicate)
    {
        $result = Maybe::nothing();

        $this->each(
            function ($value, $key) use (
                $predicate,
                &$result
            ) {
                if ($predicate($value, $key, $this)) {
                    $result = Maybe::just($value);

                    return false;
                }

                return true;
            }
        );

        return $result;
    }

    /**
     * @param callable $predicate
     *
     * @return Maybe
     */
    public function findLast(callable $predicate)
    {
        return $this->reverse()->find($predicate);
    }

    /**
     * @return MapInterface
     */
    abstract public function toMap();

    /**
     * @return ListInterface
     */
    abstract public function toList();

    /**
     * @return ListInterface
     */
    public function keys()
    {
        // This is a basic implementation. More specific classes can provide a
        // more efficient implementation.
        return $this
            ->map(function ($value, $key) {
                return $key;
            })
            ->toList();
    }

    /**
     * @return ListInterface
     */
    public function values()
    {
        // This is a basic implementation. More specific classes can provide a
        // more efficient implementation.
        return $this
            ->map(function ($value) {
                return $value;
            })
            ->toList();
    }

    /**
     * @return ListInterface
     */
    abstract public function entries();
}
