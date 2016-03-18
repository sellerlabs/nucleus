<?php

namespace SellerLabs\Nucleus\Control\Traits;

use SellerLabs\Nucleus\Control\Interfaces\ApplyInterface;
use SellerLabs\Nucleus\Control\Interfaces\ChainInterface;

/**
 * Class ChainTrait
 *
 * @method bind(callable $other)
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control\Traits
 */
trait ChainTrait
{
    /**
     * @param ApplyInterface $other
     *
     * @return ChainInterface
     */
    public function ap(ApplyInterface $other)
    {
        return $this->bind(function (callable $closure) use ($other) {
            return $other->fmap($closure);
        });
    }
}
