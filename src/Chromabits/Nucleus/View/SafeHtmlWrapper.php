<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;

/**
 * Class SafeHtmlWrapper.
 *
 * WARNING: If you use one of these, you know what you are doing.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View
 */
class SafeHtmlWrapper extends BaseObject implements RenderableInterface
{
    protected $content;

    /**
     * Construct an instance of a SafeHtmlWrapper.
     *
     * @param string $safeHtml
     */
    public function __construct($safeHtml)
    {
        parent::__construct();

        $this->content = (string) $safeHtml;
    }

    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render()
    {
        return $this->content;
    }

    /**
     * Get string representation of this object.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->content;
    }
}
