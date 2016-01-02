<?php

namespace Chromabits\Nucleus\Data;

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
     * @return static|Iterable
     */
    public function reverse()
    {
        return new static(array_reverse($this->value));
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
}
