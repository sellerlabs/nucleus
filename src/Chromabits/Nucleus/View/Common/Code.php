<?php

namespace Chromabits\Nucleus\View\Common;

use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Node;

/**
 * Class Code.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Common
 */
class Code extends Node
{
    /**
     * Construct an instance of a Code.
     *
     * @param array $attributes
     * @param RenderableInterface|RenderableInterface[]|string|string[] $content
     */
    public function __construct(
        array $attributes,
        $content
    ) {
        parent::__construct('code', $attributes, $content, false);
    }
}