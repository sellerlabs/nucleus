<?php

namespace Chromabits\Nucleus\Foundation\Interfaces;

/**
 * Interface FillableInterface
 *
 * Represents an object that is capable of restoring its state or properties
 * from an input array.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation\Interfaces
 */
interface FillableInterface
{
    /**
     * Fill properties in this object using an input array.
     *
     * @param array $input
     */
    public function fill(array $input);
}