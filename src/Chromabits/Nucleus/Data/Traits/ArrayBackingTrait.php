<?php

namespace Chromabits\Nucleus\Data\Traits;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Data\Iterable;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Exceptions\MindTheGapException;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;

use Chromabits\Nucleus\Support\Std;

trait ArrayBackingTrait
{
    use SameTypeTrait;

    /**
     * Get an empty monoid.
     *
     * @return MonoidInterface
     */
    public static function zero()
    {
        return new static([]);
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
        $this->assertSameType($other);

        return new static(Std::concat(
            $this->value,
            $other->value
        ));
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
        return $this->reverse()->foldl($closure, $initial);
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
     * @param mixed $input
     *
     * @return static
     */
    public static function of($input)
    {
        if ($input instanceof static) {
            return $input;
        }

        return new static($input);
    }

    /**
     * @param callable $callable
     *
     * @return Iterable
     */
    public function filter(callable $callable)
    {
        $result = [];

        foreach ($this->value as $key => $value) {
            if ($callable($value, $key, $this)) {
                $result[] = $value;
            }
        }

        return new static($result);
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
        Arguments::define (
            Boa::integer (),
            Boa::either (Boa::null (), Boa::integer ())
        )->check ($begin, $end);

        if ($end === null) {
            return new static(array_slice ($this->value, $begin));
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

        return new static(
            array_slice (
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

        return new static($taken);
    }

    /**
     * @param ApplyInterface $other
     *
     * @return ApplyInterface
     */
    public function ap(ApplyInterface $other)
    {
        $this->assertSameType ($other);

        $result = [];

        Std::poll (
            function ($ii) use (&$result, &$other) {
                Std::poll (
                    function ($jj) use (&$result, &$other, $ii) {
                        $result[] = Std::call (
                            $this->value[$ii],
                            $other->value[$jj]
                        );
                    },
                    count ($other->value)
                );
            },
            count ($this->value)
        );

        return $result;
    }

    /**
     * Get the value of the provided key.
     *
     * @param string $key
     *
     * @return static
     * @throws CoreException
     */
    public function lookup($key)
    {
        Arguments::define ($this->getKeyType ())->check ($key);

        if (!$this->member ($key)) {
            throw new CoreException(
                vsprintf (
                    'The key "%s" is not a member of this Map.',
                    [$key]
                )
            );
        }

        return $this->value[$key];
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
        return array_key_exists ($key, $this->value);
    }

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return Maybe
     * @throws MindTheGapException
     */
    public function lookupIn($searchKeyPath)
    {
        // TODO: Implement lookupIn() method.
        throw new MindTheGapException();
    }

    /**
     * @param array|Iterable $searchKeyPath
     *
     * @return mixed
     * @throws MindTheGapException
     */
    public function memberIn($searchKeyPath)
    {
        // TODO: Implement memberIn() method.
        throw new MindTheGapException();
    }

    /**
     * @param callable $comparator
     *
     * @return Iterable
     */
    public function sort(callable $comparator = null)
    {
        $copy = array_merge ($this->value);

        if ($comparator === null) {
            return new static(sort ($copy));
        }

        return new static(usort ($copy, $comparator));
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
     * Return a new Map of the same type containing the added key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function insert($key, $value)
    {
        Arguments::define ($this->getKeyType (), $this->getValueType ())
            ->check ($key, $value);

        $cloned = array_merge ($this->value);

        $cloned[$key] = $value;

        return new static($cloned);
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
        Arguments::define ($this->getKeyType ())->check ($key);

        $cloned = array_merge ($this->value);

        unset($cloned[$key]);

        return new static($cloned);
    }

    /**
     * Get a copy of the provided array excluding the specified values.
     *
     * @param array $excluded
     *
     * @return array
     * @throws InvalidArgumentException
     */
    public function exceptValues($excluded = [])
    {
        Arguments::define(Boa::arrOf(Boa::either(
            Boa::string(),
            Boa::integer()
        )))->check($excluded);

        return $this->filter(function ($value, $_) use ($excluded) {
            return !in_array($value, $excluded);
        });
    }

    /**
     * @param null $sortFlags
     *
     * @return static
     */
    public function unique($sortFlags = null)
    {
        return new static(array_unique($this->value, $sortFlags));
    }

    /**
     * @return array
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
                Boa::arrOf(Boa::either(
                    Boa::string(),
                    Boa::integer()
                )),
                Boa::null()
            )
        )->check($included);

        if (is_null($included)) {
            return $this;
        }

        if (count($included) == 0) {
            return static::zero();
        }

        return new static(
            array_intersect_key($this->value, array_flip($included))
        );
    }
}