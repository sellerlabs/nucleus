<?php

namespace Chromabits\Nucleus\View\Bootstrap;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Str;
use Chromabits\Nucleus\View\Common\Anchor;
use Chromabits\Nucleus\View\Common\Div;
use Chromabits\Nucleus\View\Common\Italic;

/**
 * Class DropdownFactory
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
     * Construct an instance of a DropdownFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->hash = Str::random();
        $this->options = [];
    }

    /**
     * Add an option to the dropdown menu.
     *
     * @param string $url
     * @param mixed $content
     */
    public function addOption($url, $content)
    {
        $this->options[] = new Anchor(
            [
                'class' => 'dropdown-item',
                'href' => $url
            ],
            $content
        );
    }

    /**
     * Build the dropdown element.
     *
     * @return Div
     */
    public function make()
    {
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
                    'class' => 'dropdown-menu',
                    'aria-labelledby' => $this->hash,
                ],
                $this->options
            )
        ]);
    }
}