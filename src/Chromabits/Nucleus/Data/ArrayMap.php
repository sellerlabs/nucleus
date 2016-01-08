<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\IterableInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\ListInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\MappableInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Traits\ArrayBackingTrait;

use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class ArrayMap.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
class ArrayMap extends KeyedCollection implements
    MapInterface,
    MonoidInterface,
    FoldableInterface,
    LeftFoldableInterface,
    ApplicativeInterface,
    MappableInterface,
    ListInterface
{
    use ArrayBackingTrait;

    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ArrayMap.
     *
     * @param array $value
     */
    public function __construct($value = [])
    {
        parent::__construct ();

        $this->value = $value;
        $this->size = count ($value);
    }

    /**
     * @return AbstractTypeConstraint
     */
    public function getKeyType()
    {
        // TODO: Figure out how to make this nicer.
        return Boa::any ();
    }

    /**
     * @return AbstractTypeConstraint
     */
    public function getValueType()
    {
        // TODO: Figure out how to make this nicer.
        return Boa::any ();
    }

    /**
     * @param mixed $key
     *
     * @return Maybe
     */
    public function lookup($key)
    {
        if ($this->member($key) === false) {
            return Maybe::nothing();
        }

        $copy = array_merge($this->value);

        return Maybe::just($copy[$key]);
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
                $result[$key] = $value;
            }
        }

        return static::of($result);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->value;
    }

    /**
     * @return IterableInterface
     */
    public function reverse()
    {
        return new static(array_reverse ($this->value, true));
    }

    /**
     * @return ListInterface
     */
    public function toList()
    {
        return $this->values();
    }

    /**
     * @return MapInterface
     */
    public function toMap()
    {
        return $this;
    }
}
