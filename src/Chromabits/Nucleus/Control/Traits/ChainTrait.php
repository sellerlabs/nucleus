<?php

namespace Chromabits\Nucleus\Control\Traits;

use Chromabits\Nucleus\Control\Interfaces\ApplyInterface;
use Chromabits\Nucleus\Control\Interfaces\ChainInterface;

/**
 * Class ChainTrait
 *
 * @method bind(callable $other)
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
        return $this->bind(function (callable $closure) use ($other) {
            return $other->fmap($closure);
        });
    }
}
