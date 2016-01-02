<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface FoldableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface FoldableInterface
{
    /**
     * @param callable $closure
     * @param mixed $initial
     *
     * @return static|FoldableInterface
     */
    public function foldr(callable $closure, $initial);
}
