<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Interface IterableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface IterableInterface extends LeftFoldableInterface, FoldableInterface
{
    /**
     * @return AbstractTypeConstraint
     */
    public function getKeyType();

    /**
     * @return AbstractTypeConstraint
     */
    public function getValueType();

    /**
     * @param mixed $key
     *
     * @return Maybe
     */
    public function lookup($key);

    /**
     * @param mixed $key
     *
     * @return bool
     */
    public function member($key);

    /**
     * @param mixed $value
     *
     * @return bool
     */
    public function includes($value);

    /**
     * @return mixed
     */
    public function head();

    /**
     * @return mixed
     */
    public function last();

    /**
     * @param array|IterableInterface $searchKeyPath
     *
     * @return Maybe
     */
    public function lookupIn($searchKeyPath);

    /**
     * @param array|IterableInterface $searchKeyPath
     *
     * @return bool
     */
    public function memberIn($searchKeyPath);

    /**
     * @return array
     */
    public function toArray();

    /**
     * @param callable $callable
     *
     * @return IterableInterface
     */
    public function fmap(callable $callable);

    /**
     * @param callable $callable
     *
     * @return static|IterableInterface
     */
    public function map(callable $callable);

    /**
     * @param callable $callable
     *
     * @return IterableInterface
     */
    public function filter(callable $callable);

    /**
     * @param callable $callable
     *
     * @return IterableInterface
     */
    public function filterNot(callable $callable);

    /**
     * @return IterableInterface
     */
    public function reverse();

    /**
     * @param callable $comparator
     *
     * @return IterableInterface
     */
    public function sort(callable $comparator = null);

    /**
     * @param callable $comparatorValueMapper
     * @param callable|null $comparator
     *
     * @return IterableInterface
     */
    public function sortBy(
        callable $comparatorValueMapper,
        callable $comparator = null
    );

    /**
     * @param callable $sideEffect
     *
     * @return int
     */
    public function each(callable $sideEffect);

    /**
     * @param int $begin
     * @param int|null $end
     *
     * @return IterableInterface
     */
    public function slice($begin, $end = null);

    /**
     * @return IterableInterface
     */
    public function tail();

    /**
     * @return IterableInterface
     */
    public function init();

    /**
     * @param int $amount
     *
     * @return IterableInterface
     */
    public function take($amount);

    /**
     * @param int $amount
     *
     * @return IterableInterface
     */
    public function takeLast($amount);

    /**
     * @param callable $predicate
     *
     * @return IterableInterface
     */
    public function takeWhile(callable $predicate);

    /**
     * @param callable $predicate
     *
     * @return IterableInterface
     */
    public function takeUntil(callable $predicate);

    /**
     * @return int
     */
    public function count();

    /**
     * @param callable $predicate
     *
     * @return Maybe
     */
    public function find(callable $predicate);

    /**
     * @param callable $predicate
     *
     * @return Maybe
     */
    public function findLast(callable $predicate);

    /**
     * @return MapInterface
     */
    public function toMap();

    /**
     * @return ListInterface
     */
    public function toList();

    /**
     * @return ListInterface
     */
    public function keys();

    /**
     * @return ListInterface
     */
    public function values();

    /**
     * @return ListInterface
     */
    public function entries();
}
