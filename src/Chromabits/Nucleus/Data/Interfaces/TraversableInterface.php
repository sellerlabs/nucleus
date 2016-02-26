<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface TraversableInterface
 *
 * @TODO THIS IS WORK IN PROGRESS. AVOID IMPLEMENTING.
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface TraversableInterface extends FunctorInterface
{
    /**
     * @return mixed
     */
    public function sequence();
}
