<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Foundation\BaseObject;
use Closure;

/**
 * Class Applicative
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control
 */
abstract class Applicative extends BaseObject implements ApplicativeInterface
{
    /**
     * @param Closure $closure
     *
     * @return Interfaces\ApplyInterface
     */
    public function fmap(Closure $closure)
    {
        return static::of($closure)->ap($this);
    }
}