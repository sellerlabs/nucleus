<?php

namespace Chromabits\Nucleus\Foundation\Interfaces;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;

/**
 * Interface FillableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation\Interfaces
 */
interface FillableInterface
{
    /**
     * Fill properties in this object using an input array.
     *
     * - Only fields that are mentioned in the fillable array can be set.
     * - Other keys will just be ignored completely.
     * - If a setter is present, it will be automatically called.
     *
     * @param array $input
     *
     * @throws LackOfCoffeeException
     */
    public function fill(array $input);
}