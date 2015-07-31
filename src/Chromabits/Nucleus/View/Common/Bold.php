<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\View\Interfaces\Renderable;
use Chromabits\Nucleus\View\Node;

/**
 * Class Bold.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
 */
class Bold extends Node
{
    /**
     * Construct an instance of a Button.
     *
     * @param string[] $attributes
     * @param string|Renderable|string[]|Renderable[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('b', $attributes, $content);
    }
}
