<?php

namespace SellerLabs\Nucleus\Control;

/**
 * Class Just
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control
 */
class Just extends Maybe
{
    /**
     * @inheritDoc
     */
    public function isJust()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function isNothing()
    {
        return false;
    }
}