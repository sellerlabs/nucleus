<?php

namespace SellerLabs\Nucleus\View\Common;

use SellerLabs\Nucleus\View\Interfaces\RenderableInterface;
use SellerLabs\Nucleus\View\Node;

/**
 * Class Code.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Common
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