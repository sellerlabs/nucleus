<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\Interfaces\FoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\LeftFoldableInterface;
use Chromabits\Nucleus\Data\Interfaces\MapInterface;
use Chromabits\Nucleus\Data\Interfaces\MonoidInterface;
use Chromabits\Nucleus\Data\Traits\ArrayBackingTrait;
use Chromabits\Nucleus\Meditation\Arguments;
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
    ApplicativeInterface
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
        $copy = array_merge ($this->value);

        return $copy[$key];
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->value;
    }

    /**
     * @return Iterable
     */
    public function reverse()
    {
        return new static(array_reverse ($this->value, true));
    }
}