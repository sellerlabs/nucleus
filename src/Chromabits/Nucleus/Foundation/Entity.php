<?php

namespace Chromabits\Nucleus\Foundation;

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\Interfaces\ArrayableInterface;
use Chromabits\Nucleus\Foundation\Interfaces\FillableInterface;
use Chromabits\Nucleus\Support\Str;

/**
 * Class Entity
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation
 */
abstract class Entity extends BaseObject implements
    ArrayableInterface,
    FillableInterface
{
    /**
     * Define which properties can be "filled" using an input array.
     *
     * When set to `null`, the entity is considered to not declare any fillable
     * fields, which will cause an exception to be thrown if a fill operation
     * is attempted on the entity.
     *
     * To declare that there are no fields that can be filled, use an empty
     * array ([]).
     *
     * @var null|string[]
     */
    protected $fillable = null;

    /**
     * Get which fields should be hidden from serialization, such as toArray().
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get which fields should be included in serialization.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * Fill properties in this object using an input array.
     *
     * - Only fields that are mentioned in the fillable array can be set.
     * - Other keys will just be ignored completely.
     * - If a setter is present, it will be automatically called.
     *
     * @param array $input
     *
     * @return $this
     * @throws LackOfCoffeeException
     */
    public function fill(array $input)
    {
        $this->assertIsFillable();

        ArrayMap::of($input)
            ->only($this->getFillable())
            ->each(function ($value, $key) {
                $setter = vsprintf('set%s', [Str::studly($key)]);

                if (method_exists($this, $setter)) {
                    $this->$setter($value);

                    return;
                }

                $camel = Str::camel($key);
                $this->$camel = $value;
            });

        return $this;
    }

    /**
     * Assert that this entity can be filled.
     *
     * @throws LackOfCoffeeException
     */
    protected function assertIsFillable()
    {
        if ($this->getFillable() === null) {
            throw new LackOfCoffeeException(
                'Unable to fill an entity that has not declared which'
                . ' properties are fillable.'
            );
        }
    }

    /**
     * Get which fields should be allowed to be filled.
     *
     * @return null|string[]
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Get which fields should be included in serialization.
     *
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Get an array representation of this entity.
     *
     * @return array
     */
    public function toArray()
    {
        $result = [];

        ArrayList::of($this->getFillable())
            ->append(ArrayList::of($this->getVisible()))
            ->unique(SORT_STRING)
            ->exceptValues($this->getHidden())
            ->each(function ($key) use (&$result) {
                $getter = vsprintf('get%s', [Str::studly($key)]);

                if (method_exists($this, $getter)) {
                    $result[$key] = $this->$getter();

                    return;
                }

                $camel = Str::camel($key);
                $result[$key] = $this->$camel;
            });

        return $result;
    }

    /**
     * Get which fields should not be included during serialization.
     *
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }
}
