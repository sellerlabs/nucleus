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

use SellerLabs\Nucleus\View\Node;

/**
 * Class UnorderedList.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Common
 */
class UnorderedList extends Node
{
    /**
     * Construct an instance of a Button.
     *
     * @param string[] $attributes
     * @param ListItem[] $content
     */
    public function __construct($attributes, $content = [])
    {
        parent::__construct('ul', $attributes, $content);
    }
}
