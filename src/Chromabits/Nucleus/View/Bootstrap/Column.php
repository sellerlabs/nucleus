<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Bootstrap;

use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Node;

/**
 * Class Column.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Bootstrap
 */
class Column extends Node
{
    /**
     * @var int
     */
    protected $extraSmall;

    /**
     * @var int
     */
    protected $small;

    /**
     * @var int
     */
    protected $medium;

    /**
     * @var int
     */
    protected $large;

    /**
     * Construct an instance of a Container.
     *
     * @param array $attributes
     * @param string|RenderableInterface|string[]|RenderableInterface[] $content
     */
    public function __construct(
        array $attributes,
        $content
    ) {
        $classes = [];

        $this->extraSmall = (int) Arr::dotGet($attributes, 'extraSmall', 0);
        $this->small = (int) Arr::dotGet($attributes, 'small', 0);
        $this->medium = (int) Arr::dotGet($attributes, 'medium', 0);
        $this->large = (int) Arr::dotGet($attributes, 'large', 0);

        if ($this->extraSmall > 0) {
            $classes[] = 'col-xs-' . $this->extraSmall;
        }

        if ($this->small > 0) {
            $classes[] = 'col-sm-' . $this->small;
        }

        if ($this->medium > 0) {
            $classes[] = 'col-md-' . $this->medium;
        }

        if ($this->large > 0) {
            $classes[] = 'col-lg-' . $this->large;
        }

        if (Arr::has($attributes, 'class')) {
            $classes[] = $attributes['class'];
        }

        $attributes['class'] = implode(' ', $classes);

        parent::__construct('div', $attributes, $content, false);
    }
}
