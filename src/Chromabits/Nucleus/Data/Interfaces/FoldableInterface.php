<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Closure;

/**
 * Interface FoldableInterface
 *
 * @TODO THIS IS WORK IN PROGRESS. AVOID IMPLEMENTING.
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface FoldableInterface
{
    public function reduce(Closure $closure, $initial);
}