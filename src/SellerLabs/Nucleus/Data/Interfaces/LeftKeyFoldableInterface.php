<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

/**
 * Interface LeftKeyFoldable
 *
 * A class implementing foldlWithKeys.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
 */
interface LeftKeyFoldableInterface extends LeftFoldableInterface
{
    /**
     * Combine all the elements in the traversable using a combining operation.
     *
     * @param callable $callback
     * @param mixed $initial
     *
     * @return mixed
     */
    public function foldlWithKeys(callable $callback, $initial);
}
