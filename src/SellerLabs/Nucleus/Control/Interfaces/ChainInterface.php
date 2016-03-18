<?php

namespace SellerLabs\Nucleus\Control\Interfaces;

use Closure;

/**
 * Interface ChainInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control\Interfaces
 */
interface ChainInterface extends ApplyInterface
{
    /**
     * @param callable|Closure $closure
     *
     * @return ChainInterface
     */
    public function bind(callable $closure);
}
