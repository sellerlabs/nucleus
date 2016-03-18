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
 * Class Row.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\View\Bootstrap
 */
class Row extends Node
{
    /**
     * Construct an instance of a Row.
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
        if (Arr::has($attributes, 'class')) {
            $attributes['class'] = implode(' ', [
                'row',
                $attributes['class'],
            ]);
        } else {
            $attributes['class'] = 'row';
        }

        parent::__construct('div', $attributes, $content, false);
    }
}
