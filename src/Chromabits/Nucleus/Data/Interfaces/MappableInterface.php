<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface Mappable
 *
 * An object that can be converted or represented as a MapInterface.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface MappableInterface
{
    /**
     * @return MapInterface
     */
    public function toMap();
}
