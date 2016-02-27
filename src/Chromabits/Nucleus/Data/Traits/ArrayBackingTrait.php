<?php

namespace Chromabits\Nucleus\Data\Traits;

use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Iterable;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Exceptions\MindTheGapException;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Support\Std;

/**
 * Trait ArrayBackingTrait.
 *
 * @method self reverse()
 *
 * @property int $size
 * @property array $value
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Traits
 */
trait ArrayBackingTrait
{
    use SameTypeTrait;

    /**
     * @return AbstractTypeConstraint
     */
    protected abstract function getKeyType();

    /**
     * @param callable $function
     *
     * @return static
     */
    protected abstract function map(callable $function);

    /**
     * Apply a function to this functor.
     *
     * @param callable $closure
     *
     * @return FunctorInterface
     */
    public function fmap(callable $closure)
    {
        return static::of(Std::map($closure, $this->value));
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
        return $this->reverse()->foldl(
            function ($acc, $x) use ($closure) {
                return $closure($x, $acc);
            },
            $initial
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
    public function foldrWithKeys(callable $closure, $initial)
    {
        return $this
            ->reverse()
            ->foldlWithKeys(
                function ($acc, $key, $x) use ($closure) {
                    return $closure($key, $x, $acc);
                },
                $initial
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
        return array_reduce($this->value, $closure, $initial);
    }

    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldlWithKeys(callable $callback, $initial)
    {
        $accumulator = $initial;

        foreach ($this->value as $key => $value) {
            $accumulator = $callback($accumulator, $key, $value);
        }

        return $accumulator;
    }

    /**
     * @param int $begin
     * @param int $end
     *
     * @return Iterable
     * @throws CoreException
     * @throws InvalidArgumentException
     */
    public function slice($begin, $end = null)
    {
        Arguments::define(
            Boa::integer(),
            Boa::either(Boa::null(), Boa::integer())
        )->check($begin, $end);

        if ($end === null) {
            return static::of(array_slice($this->value, $begin));
        }

        $actualBegin = $begin;
        $actualEnd = $end;

        if ($begin < 0) {
            $actualBegin = $this->size - $begin;
        }

        if ($end < 0) {
            $actualEnd = $this->size - $end;
        }

        $diff = $actualEnd - $actualBegin;

        if ($diff < 0) {
            throw new CoreException('Invalid range.');
        }

        return static::of(
            array_slice(
                $this->value,
                $actualBegin,
                $diff
            )
        );
    }

    /**
     * @param callable $predicate
     *
     * @return Iterable
     */
    public function takeWhile(callable $predicate)
    {
        $taken = [];

        foreach ($this->value as $key => $value) {
            if ($predicate($value, $key, $this)) {
                $taken[] = $value;
            }
        }

        return static::of($taken);
    }

    /**
     * @param ApplyInterface $other
     *
     * @return ApplyInterface
     */
    public function ap(ApplyInterface $other)
    {
        $this->assertSameType($other);

        $result = [];

        Std::poll(
            function ($ii) use (&$result, &$other) {
                Std::poll(
                    function ($jj) use (&$result, &$other, $ii) {
                        $result[] = Std::call(
                            $this->value[$ii],
                            $other->value[$jj]
                        );
                    },
                    count($other->value)
                );
            },
            count($this->value)
        );

        return $result;
    }

    /**
     * Get the value of the provided key.
     *
     * @param string $key
     *
     * @return Maybe
     * @throws CoreException
     */
    public function lookup($key)
    {
        Arguments::define($this->getKeyType())->check($key);

        if (!$this->member($key)) {
            return Maybe::nothing();
        }

        return Maybe::just($this->value[$key]);
    }

    /**
     * Return whether or not the map contains the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function member($key)
    {
        return array_key_exists($key, $this->value);
    }

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return Maybe
     */
    public function lookupIn($searchKeyPath)
    {
        $path = ArrayList::of($searchKeyPath);

        if ($path->count() === 0) {
            return Maybe::nothing();
        }

        if ($path->count() === 1) {
            return $this->lookup($path->head());
        }

        $value = $this->lookup($path->head());

        if ($value->isNothing()) {
            return $value;
        }

        $innerValue = Maybe::fromJust($value);

        if ($innerValue instanceof Iterable) {
            return $innerValue->lookupIn($path->tail());
        }

        return Maybe::nothing();
    }

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return bool
     * @throws MindTheGapException
     */
    public function memberIn($searchKeyPath)
    {
        $path = ArrayList::of($searchKeyPath);

        if ($path->count() === 0) {
            return false;
        }

        if ($path->count() === 1) {
            return $this->member($path->head());
        }

        if ($this->member($path->head()) === false) {
            return false;
        }

        $innerValue = Maybe::fromJust($this->lookup($path->head()));

        if ($innerValue instanceof Iterable) {
            return $innerValue->memberIn($path->tail());
        }

        return false;
    }

    /**
     * @param callable $comparator
     *
     * @return Iterable
     */
    public function sort(callable $comparator = null)
    {
        $copy = array_merge($this->value);

        if ($comparator === null) {
            return static::of(sort($copy));
        }

        return static::of(usort($copy, $comparator));
    }

    /**
     * @param callable $sideEffect
     *
     * @return int
     */
    public function each(callable $sideEffect)
    {
        $count = 0;

        foreach ($this->value as $key => $value) {
            $count++;

            if ($sideEffect($value, $key, $this) === false) {
                return $count;
            }
        }

        return $count;
    }

    /**
     * Return a new Map of the same type without the specified key.
     *
     * @param string $key
     *
     * @return static
     * @internal param mixed $value
     */
    public function delete($key)
    {
        Arguments::define($this->getKeyType())->check($key);

        $cloned = array_merge($this->value);

        unset($cloned[$key]);

        return static::of($cloned);
    }

    /**
     * Get a copy of the provided array excluding the specified values.
     *
     * @param array $excluded
     *
     * @return static|Iterable
     * @throws InvalidArgumentException
     */
    public function exceptValues($excluded = [])
    {
        Arguments::define(
            Boa::arrOf(
                Boa::either(
                    Boa::string(),
                    Boa::integer()
                )
            )
        )->check($excluded);

        return $this->filter(
            function ($value) use ($excluded) {
                return !in_array($value, $excluded);
            }
        );
    }

    /**
     * @param int|null $sortFlags
     *
     * @return static
     */
    public function unique($sortFlags = null)
    {
        return static::of(array_unique($this->value, $sortFlags));
    }

    /**
     * @return ArrayList
     */
    public function keys()
    {
        return new ArrayList(array_keys($this->value));
    }

    /**
     * @param string $glue
     *
     * @return string
     */
    public function join($glue = '')
    {
        return implode($glue, $this->value);
    }

    /**
     * Get an array with only the specified keys of the provided array.
     *
     * @param array|null $included
     *
     * @return static
     */
    public function only($included = [])
    {
        Arguments::define(
            Boa::either(
                Boa::arrOf(
                    Boa::either(
                        Boa::string(),
                        Boa::integer()
                    )
                ),
                Boa::null()
            )
        )->check($included);

        if (is_null($included)) {
            return $this;
        }

        if (count($included) == 0) {
            return static::zero();
        }

        return static::of(
            array_intersect_key($this->value, array_flip($included))
        );
    }

    /**
     * Get an empty monoid.
     *
     * @return static|MonoidInterface
     */
    public static function zero()
    {
        return static::of([]);
    }

    /**
     * Attempt to set a field using the provided updater function.
     *
     * @param string $key
     * @param callable $updater
     * @param mixed|null $default
     *
     * @return static
     */
    public function update($key, callable $updater, $default = null)
    {
        return $this->insert(
            $key,
            $updater(
                Maybe::fromMaybe($default, $this->lookup($key))
            )
        );
    }

    /**
     * Return a new Map of the same type containing the added key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function insert($key, $value)
    {
        Arguments::define($this->getKeyType(), $this->getValueType())
            ->check($key, $value);

        $cloned = array_merge($this->value);

        $cloned[$key] = $value;

        return static::of($cloned);
    }

    /**
     * @return ListInterface
     */
    public function values()
    {
        return new ArrayList(array_values($this->value));
    }

    /**
     * @return ListInterface
     */
    public function entries()
    {
        return $this
            ->map(function ($value, $key) {
                return new ArrayList([$key, $value]);
            })
            ->toList();
    }
}
