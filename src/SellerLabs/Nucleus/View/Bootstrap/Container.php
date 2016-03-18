<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\View\Bootstrap;

use SellerLabs\Nucleus\Support\Arr;
use SellerLabs\Nucleus\View\Node;

/**
 * Class Container.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Bootstrap
 */
class Container extends Node
{
    /**
     * @var bool
     */
    protected $fluid;

    /**
     * Construct an instance of a Container.
     *
     * @param array $attributes
     * @param \string[] $content
     * @param bool|false $fluid
     */
    public function __construct(
        array $attributes,
        $content,
        $fluid = false
    ) {
        $this->fluid = $fluid;

        if (Arr::has($attributes, 'class')) {
            $attributes['class'] = implode(' ', [
                $this->fluid ? 'container-fluid' : 'container',
                $attributes['class'],
            ]);
        } else {
            $attributes['class'] = $this->fluid ?
                'container-fluid' : 'container';
        }

        parent::__construct('div', $attributes, $content, false);
    }
}
