<?php

namespace Chromabits\Nucleus\Foundation\Interfaces;

/**
 * Interface ArrayableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation\Interfaces
 */
interface ArrayableInterface
{
    /**
     * Get an array representation of this entity.
     *
     * @return array
     */
    public function toArray();
}