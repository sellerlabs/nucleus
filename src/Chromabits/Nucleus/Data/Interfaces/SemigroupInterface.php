<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface SemigroupInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface SemigroupInterface
{
    /**
     * Append another semigroup and return the result.
     *
     * @param SemigroupInterface $other
     *
     * @return SemigroupInterface
     */
    public function append(SemigroupInterface $other);
}
