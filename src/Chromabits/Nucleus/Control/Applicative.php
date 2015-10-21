<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;
use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
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
     * @param callable|Closure $closure
     *
     * @return ApplyInterface
     */
    public function fmap(callable $closure)
    {
        return static::of($closure)->ap($this);
    }
}
