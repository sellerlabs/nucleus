<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface ListableInterface
 *
 * An object that can be converted or represented as a ListInterface.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface ListableInterface
{
    /**
     * @return ListInterface
     */
    public function toList();
}
