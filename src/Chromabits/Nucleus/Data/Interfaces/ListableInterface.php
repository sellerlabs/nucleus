<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface ListableInterface
 *
 * An object that can be converted or represented as a ListInterface.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface ListableInterface
{
    /**
     * @return ListInterface
     */
    public function toList();
}
