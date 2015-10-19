<?php

namespace Chromabits\Nucleus\Control;

/**
 * Class Just
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control
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