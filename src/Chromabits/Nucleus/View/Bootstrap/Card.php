<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Bootstrap;

use Chromabits\Nucleus\View\Common\Div;

/**
 * Class Card.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Bootstrap
 */
class Card extends Div
{
    /**
     * @return array
     */
    public function getDefaultAttributes()
    {
        return ['class' => 'card'];
    }
}
