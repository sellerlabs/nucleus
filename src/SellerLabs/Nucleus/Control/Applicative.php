<?php

namespace SellerLabs\Nucleus\Control;

use SellerLabs\Nucleus\Control\Interfaces\ApplicativeInterface;
use SellerLabs\Nucleus\Control\Interfaces\ApplyInterface;
use SellerLabs\Nucleus\Foundation\BaseObject;
use Closure;

/**
 * Class Applicative
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control
 */
abstract class Applicative extends BaseObject implements ApplicativeInterface
{
    /**
     * @param callable|Closure $closure
     *
     * @return ApplyInterface
     */
    public function fmap(callable $closure)
    {
        return static::of($closure)->ap($this);
    }
}
