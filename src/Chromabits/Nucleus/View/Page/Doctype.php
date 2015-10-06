<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Page;

use Chromabits\Nucleus\Support\Html as HtmlUtils;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Chromabits\Nucleus\View\SafeHtmlWrapper;

/**
 * Class Doctype.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Page
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
