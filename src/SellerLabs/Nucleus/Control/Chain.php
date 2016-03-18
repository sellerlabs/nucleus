<?php

namespace SellerLabs\Nucleus\Control;

use SellerLabs\Nucleus\Control\Interfaces\ChainInterface;
use SellerLabs\Nucleus\Control\Traits\ChainTrait;

/**
 * Class Chain
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control
 */
abstract class Chain implements ChainInterface
{
    use ChainTrait;
}