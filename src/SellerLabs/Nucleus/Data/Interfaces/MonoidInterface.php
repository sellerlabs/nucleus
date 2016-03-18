<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface MonoidInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
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