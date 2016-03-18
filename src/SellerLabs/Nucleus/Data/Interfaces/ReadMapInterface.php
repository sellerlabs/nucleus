<?php

namespace SellerLabs\Nucleus\Data\Interfaces;
use SellerLabs\Nucleus\Control\Maybe;

/**
 * Interface ReadMapInterface
 *
 * A read-only Map.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface ReadMapInterface
{
    /**
     * Get the value of the provided key.
     *
     * @param string $key
     *
     * @return Maybe
     */
    public function lookup($key);

    /**
     * Return whether or not the map contains the specified key.
     *
     * @param string $key
     *
     * @return bool
     */
    public function member($key);
}
