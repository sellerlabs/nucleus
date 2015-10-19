<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface TraversableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface TraversableInterface extends FunctorInterface
{
    public function sequence();
}