<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Data\Interfaces\IterableInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Traits\ArrayBackingTrait;
use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class ArrayList
 * An implementation of a List backed by an array.
 * This is an early WIP. Interfaces might change over time.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
class ArrayList extends IndexedCollection implements ListInterface, MapInterface
{
    use ArrayBackingTrait;

    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of an ArrayList.
     *
     * @param array $initial
     */
    public function __construct(array $initial = [])
    {
        parent::__construct();

        $this->value = $initial;
        $this->size = count($initial);
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
     * @throws CoreException
     */
    protected function assertNotEmpty()
    {
        if ($this->size < 1) {
            throw new CoreException('List is empty');
        }
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
}
