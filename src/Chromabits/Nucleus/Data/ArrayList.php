<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Data\Traits\SameTypeTrait;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

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
class ArrayList implements ListInterface, MapInterface
{
    use SameTypeTrait;

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
     * Get an empty monoid.
     *
     * @return MonoidInterface
     */
    public static function zero()
    {
        return new static();
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
        return array_reduce(Arr::reverse($this->value), $closure, $initial);
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
     * @return ApplicativeInterface
     */
    public static function of(...$input)
    {
        return new static($input);
    }

    /**
     * @param ApplyInterface $other
     *
     * @return ApplyInterface
     */
    public function ap(ApplyInterface $other)
    {
        $this->assertSameType($other);

        /** @var ArrayList $other */
        $result = [];

        Std::poll(function ($ii) use (&$result, &$other) {
            Std::poll(function ($jj) use (&$result, &$other, $ii) {
                $result[] = Std::call(
                    $this->value[$ii],
                    $other->value[$jj]
                );
            }, count($other->value));
        }, count($this->value));

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
        if (!$this->member($key)) {
            throw new CoreException(vsprintf(
                'The key "%s" is not a member of this Map.',
                [$key]
            ));
        }

        return $this->value[$key];
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
        $cloned = array_merge($this->value);

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
     *
     */
    public function delete($key)
    {
        $cloned = array_merge($this->value);

        unset($cloned[$key]);

        return new static($cloned);
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
}
