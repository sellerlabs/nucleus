<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Page;

use SellerLabs\Nucleus\Support\Html as HtmlUtils;
use SellerLabs\Nucleus\View\Interfaces\RenderableInterface;
use SellerLabs\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use SellerLabs\Nucleus\View\SafeHtmlWrapper;

/**
 * Class Doctype.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Page
 */
class Doctype implements RenderableInterface, SafeHtmlProducerInterface
{
    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render()
    {
        return '<!DOCTYPE html>';
    }

    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        return HtmlUtils::safe($this->render());
    }
}
