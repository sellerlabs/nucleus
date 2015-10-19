<?php

namespace Chromabits\Nucleus\Control;

/**
 * Class Nothing
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control
 */
class Nothing extends Maybe
{
    protected $value = null;

    /**
     * @inheritdoc
     */
    public function isJust()
    {
        return false;
    }

    /**
     * @inheritdoc
     */
    public function isNothing()
    {
        return true;
    }
}