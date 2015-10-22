<?php

namespace Chromabits\Nucleus\Data\Interfaces;

use Chromabits\Nucleus\Control\Interfaces\ApplicativeInterface;

/**
 * Class ArrayList
 *
 * An implementation of a List backed by an array.
 *
 * This is an early WIP. Interfaces might change over time.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
interface ListInterface extends MonoidInterface, FoldableInterface,
    LeftFoldableInterface, ApplicativeInterface
{
    //
}
