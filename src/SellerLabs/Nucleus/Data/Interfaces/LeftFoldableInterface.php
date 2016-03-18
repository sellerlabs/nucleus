<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

use Closure;

/**
 * Interface RightFoldable
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface LeftFoldableInterface
{
    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable|Closure $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldl(callable $closure, $initial);
}
