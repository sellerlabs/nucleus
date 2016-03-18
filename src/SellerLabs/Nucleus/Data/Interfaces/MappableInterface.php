<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface Mappable
 *
 * An object that can be converted or represented as a MapInterface.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface MappableInterface
{
    /**
     * @return MapInterface
     */
    public function toMap();
}
