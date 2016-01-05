<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;

/**
 * Interface ListInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface ListInterface extends
    MonoidInterface,
    FoldableInterface,
    LeftFoldableInterface,
    ApplicativeInterface,
    IterableInterface
{
    //
}
