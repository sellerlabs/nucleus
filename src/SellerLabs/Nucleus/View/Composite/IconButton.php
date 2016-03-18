<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Composite;

use SellerLabs\Nucleus\Support\Html;
use SellerLabs\Nucleus\View\Common\Button;
use SellerLabs\Nucleus\View\Common\Italic;
use SellerLabs\Nucleus\View\Interfaces\RenderableInterface;
use SellerLabs\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use SellerLabs\Nucleus\View\SafeHtmlWrapper;

/**
 * Class IconButton.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Composite
 */
class IconButton implements RenderableInterface, SafeHtmlProducerInterface
{
    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var RenderableInterface|RenderableInterface[]|string|string[]
     */
    protected $content;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @param string $icon
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     * @param array $attributes
     */
    public function __construct($icon, $content = '', $attributes = [])
    {
        $this->icon = $icon;
        $this->content = $content;
        $this->attributes = $attributes;
    }

    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render()
    {
        return (new Button($this->attributes, [
            new Italic(['class' => 'icon ' . $this->icon]),
            $this->content,
        ]))->render();
    }

    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        return Html::safe($this->render());
    }
}
