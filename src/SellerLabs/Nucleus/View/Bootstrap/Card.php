<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Bootstrap;

use SellerLabs\Nucleus\View\Common\Div;

/**
 * Class Card.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Bootstrap
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
