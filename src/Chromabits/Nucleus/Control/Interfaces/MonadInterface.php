<?php

namespace Chromabits\Nucleus\Control\Interfaces;

use Closure;

/**
 * Interface MonadInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads\Interfaces
 */
interface MonadInterface
{
    /**
     * >>==
     *
     * @param Closure $closure
     *
     * @return MonadInterface
     */
    public function bind(Closure $closure);

    /**
     * return
     *
     * @param $value
     *
     * @return MonadInterface
     */
    public static function unit($value);
}