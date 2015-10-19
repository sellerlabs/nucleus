<?php

namespace Chromabits\Nucleus\Control\Interfaces;

use Closure;

/**
 * Interface MonadInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads\Interfaces
 */
interface MonadInterface extends ApplyInterface, ChainInterface
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
     * return/mreturn/unit
     *
     * @param $value
     *
     * @return MonadInterface
     */
    public static function of($value);
}