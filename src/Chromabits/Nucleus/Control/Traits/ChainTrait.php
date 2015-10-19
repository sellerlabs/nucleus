<?php

namespace Chromabits\Nucleus\Control\Traits;

use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
use Chromabits\Nucleus\Control\Interfaces\ChainInterface;
use Closure;

/**
 * Class ChainTrait
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control\Traits
 */
trait ChainTrait
{
    /**
     * @param ApplyInterface $other
     *
     * @return ChainInterface
     */
    public function ap(ApplyInterface $other)
    {
        return $this->chain(function (Closure $closure) use ($other) {
            return $other->fmap($closure);
        });
    }
}