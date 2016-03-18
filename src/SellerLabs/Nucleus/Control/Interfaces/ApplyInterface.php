<?php

namespace SellerLabs\Nucleus\Control\Interfaces;

use SellerLabs\Nucleus\Data\Interfaces\FunctorInterface;

/**
 * Interface ApplyInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control\Interfaces
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