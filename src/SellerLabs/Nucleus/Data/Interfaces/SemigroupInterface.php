<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface SemigroupInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
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
