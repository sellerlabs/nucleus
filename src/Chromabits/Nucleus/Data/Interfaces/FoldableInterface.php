<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Closure;

/**
 * Interface FoldableInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface FoldableInterface
{
    public function foldr(callable $closure, $initial);
}
