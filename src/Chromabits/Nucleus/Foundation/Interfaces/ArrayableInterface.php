<?php

namespace Chromabits\Nucleus\Foundation\Interfaces;

/**
 * Interface ArrayableInterface
 *
 * Represents an object that can produce an array representation of itself.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation\Interfaces
 */
interface ArrayableInterface
{
    /**
     * Get an array representation of this object.
     *
     * @return array
     */
    public function toArray();
}