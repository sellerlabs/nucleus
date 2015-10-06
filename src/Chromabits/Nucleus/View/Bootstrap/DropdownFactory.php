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

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Str;
use Chromabits\Nucleus\View\Common\Anchor;
use Chromabits\Nucleus\View\Common\Div;
use Chromabits\Nucleus\View\Common\Italic;

/**
 * Class DropdownFactory.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Bootstrap
 */
class DropdownFactory extends BaseObject
{
    /**
     * @var string
     */
    protected $hash;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var bool
     */
    protected $right;

    /**
     * Construct an instance of a DropdownFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->hash = Str::random();
        $this->options = [];
        $this->right = false;
    }

    /**
     * Add an option to the dropdown menu.
     *
     * @param string $url
     * @param mixed $content
     *
     * @return $this
     */
    public function addOption($url, $content)
    {
        $this->options[] = new Anchor(
            [
                'class' => 'dropdown-item',
                'href' => $url,
            ],
            $content
        );

        return $this;
    }

    /**
     * Display the menu from the top-right corner.
     */
    public function fromRight()
    {
        $this->right = true;

        return $this;
    }

    /**
     * Build the dropdown element.
     *
     * @return Div
     */
    public function make()
    {
        $menuClasses = ['dropdown-menu'];

        if ($this->right) {
            $menuClasses[] = 'dropdown-menu-right';
        }

        return new Div(['class' => 'dropdown'], [
            new Anchor(
                [
                    'id' => $this->hash,
                    'data-toggle' => 'dropdown',
                    'aria-haspopup' => 'true',
                    'aria-expanded' => 'false',
                ],
                new Italic(['class' => 'fa fa-ellipsis-h'])
            ),
            new Div(
                [
                    'class' => $menuClasses,
                    'aria-labelledby' => $this->hash,
                ],
                $this->options
            ),
        ]);
    }
}
