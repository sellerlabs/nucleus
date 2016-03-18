<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Interfaces;

/**
 * Interface RenderableInterface.
 *
 * Represents an object that can be rendered into a string.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Interfaces
 */
interface RenderableInterface
{
    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render();
}
