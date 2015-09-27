<?php

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Node;

/**
 * Class DefinitionTerm
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
 */
class DefinitionTerm extends Node
{
    /**
     * Construct an instance of an DefinitionTerm.
     *
     * @param string[] $attributes
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     */
    public function __construct($attributes, $content = '')
    {
        parent::__construct('dt', $attributes, $content);
    }
}