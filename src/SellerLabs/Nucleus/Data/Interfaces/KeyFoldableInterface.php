<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface KeyFoldableInterface
 *
 * A class implementing foldrWithKeys.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface KeyFoldableInterface extends FoldableInterface
{
    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable $closure
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldrWithKeys(callable $closure, $initial);
}
