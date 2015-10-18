<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Closure;

/**
 * Interface FunctorInterface
 *
 * WIP
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads\Interfaces
 */
interface FunctorInterface
{
    public function fmap(Closure $closure, FunctorInterface $functor);
}