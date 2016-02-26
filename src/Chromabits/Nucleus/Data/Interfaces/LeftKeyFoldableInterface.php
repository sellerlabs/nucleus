<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface LeftKeyFoldable
 *
 * A class implementing foldlWithKeys.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
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
