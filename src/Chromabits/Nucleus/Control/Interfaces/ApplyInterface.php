<?php

namespace Chromabits\Nucleus\Control\Interfaces;

use Chromabits\Nucleus\Data\Interfaces\FunctorInterface;

/**
 * Interface ApplyInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control\Interfaces
 */
interface ApplyInterface extends FunctorInterface
{
    /**
     * @param ApplyInterface $other
     *
     * @return ApplyInterface
     */
    public function ap(ApplyInterface $other);
}