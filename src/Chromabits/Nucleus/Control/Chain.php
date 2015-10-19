<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\Interfaces\ChainInterface;
use Chromabits\Nucleus\Control\Traits\ChainTrait;

/**
 * Class Chain
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control
 */
abstract class Chain implements ChainInterface
{
    use ChainTrait;
}