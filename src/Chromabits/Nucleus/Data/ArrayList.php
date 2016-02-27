<?php

namespace Chromabits\Nucleus\Data;

use ArrayObject;
use Chromabits\Nucleus\Data\Interfaces\IterableInterface;
use Chromabits\Nucleus\Data\Interfaces\KeyFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftKeyFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\ListableInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\MappableInterface;
use Chromabits\Nucleus\Data\Interfaces\SemigroupInterface;
use Chromabits\Nucleus\Data\Traits\ArrayBackingTrait;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\Interfaces\ArrayableInterface;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;

/**
 * Class ArrayList
 * An implementation of a List backed by an array.
 * This is an early WIP. Interfaces might change over time.
 *
 * @method map(callable $callable): ArrayList|Iterable
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
class ArrayList extends IndexedCollection implements
    ListInterface,
    MapInterface,
    ListableInterface,
    MappableInterface,
    KeyFoldableInterface,
    LeftKeyFoldableInterface
{
    use ArrayBackingTrait;

    /**
     * @var array
     */
    protected $value;

    /**
     * @param mixed $input
     *
     * @return ArrayList|static
     */
    public static function of($input)
    {
        if ($input instanceof static) {
            return $input;
        } elseif ($input instanceof ArrayableInterface) {
            return new static($input->toArray());
        }

        return new static($input);
    }

    /**
     * Construct an instance of an ArrayList.
     *
     * @param array|ArrayObject $value
     */
    public function __construct(array $value = [])
    {
        parent::__construct();

        if ($value instanceof ArrayObject) {
            $value = $value->getArrayCopy();
        }

        $this->value = array_values($value);
        $this->size = count($value);
    }

    /**
     * @return AbstractTypeConstraint
     */
    public function getValueType()
    {
        // TODO: Figure out how to make this nicer.
        return Boa::any();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_values($this->value);
    }

    /**
     * @return static|IterableInterface
     */
    public function reverse()
    {
        return new static(array_reverse($this->value));
    }

    /**
     * @param callable $callable
     *
     * @return IterableInterface
     */
    public function filter(callable $callable)
    {
        $result = [];

        foreach ($this->value as $key => $value) {
            if ($callable($value, $key, $this)) {
                $result[] = $value;
            }
        }

        return static::of($result);
    }

    /**
     * @return ListInterface
     */
    public function toList()
    {
        return $this;
    }

    /**
     * @return MapInterface
     */
    public function toMap()
    {
        return new ArrayMap($this->value);
    }

    /**
     * @throws CoreException
     */
    protected function assertNotEmpty()
    {
        if ($this->size < 1) {
            throw new CoreException('List is empty');
        }
    }

    /**
     * Append another semigroup and return the result.
     *
     * @param SemigroupInterface $other
     *
     * @return static|SemigroupInterface
     * @throws CoreException
     * @throws MismatchedArgumentTypesException
     */
    public function append(SemigroupInterface $other)
    {
        if ($other instanceof static) {
            return new static(array_merge($this->value, $other->value));
        }

        $this->throwMismatchedDataTypeException($other);
    }
}
