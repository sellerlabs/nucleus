<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Common;

use SellerLabs\Nucleus\View\Interfaces\RenderableInterface;
use SellerLabs\Nucleus\View\Node;

/**
 * Class TableHeaderCell.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Common
 */
class TableHeaderCell extends Node
{
    /**
     * Construct an instance of a Button.
     *
     * @param string[] $attributes
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('th', $attributes, $content);
    }
}
