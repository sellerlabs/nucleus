<?php

namespace SellerLabs\Nucleus\Foundation\Interfaces;

/**
 * Interface ArrayableInterface
 *
 * Represents an object that can produce an array representation of itself.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Foundation\Interfaces
 */
interface ArrayableInterface
{
    /**
     * Get an array representation of this object.
     *
     * @return array
     */
    public function toArray();
}