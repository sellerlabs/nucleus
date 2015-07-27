<?php

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\View\Interfaces\Renderable;
use Chromabits\Nucleus\View\Node;

/**
 * Class UnorderedList
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
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
