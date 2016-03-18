<?php

namespace SellerLabs\Nucleus\Data\Interfaces;

use SellerLabs\Nucleus\Control\Interfaces\ApplicativeInterface;

/**
 * Interface ListInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data\Interfaces
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
