<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface MonoidInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface MonoidInterface extends SemigroupInterface
{
    /**
     * Get an empty monoid.
     *
     * @return MonoidInterface
     */
    public static function zero();
}