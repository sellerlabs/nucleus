<?php

namespace SellerLabs\Nucleus\Control\Interfaces;

use Closure;

/**
 * Interface MonadInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Monads\Interfaces
 */
interface MonadInterface extends ApplyInterface, ChainInterface
{
    /**
     * >>==
     *
     * @param callable|Closure $closure
     *
     * @return MonadInterface
     */
    public function bind(callable $closure);

    /**
     * return/mreturn/unit
     *
     * @param $value
     *
     * @return MonadInterface
     */
    public static function of($value);
}
