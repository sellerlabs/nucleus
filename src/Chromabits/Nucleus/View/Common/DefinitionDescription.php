<?php

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Node;

/**
 * Class DefinitionDescription
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
 */
class DefinitionDescription extends Node
{
    /**
     * Construct an instance of a DefinitionDescription.
     *
     * @param string[] $attributes
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('dd', $attributes, $content);
    }
}