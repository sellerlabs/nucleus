<?php

namespace Chromabits\Nucleus\View\Composite;

use Chromabits\Nucleus\View\Common\Button;
use Chromabits\Nucleus\View\Common\Italic;
use Chromabits\Nucleus\View\Interfaces\Renderable;

/**
 * Class IconButton
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Composite
 */
class IconButton implements Renderable
{
    protected $attributes;

    protected $content;

    protected $icon;

    /**
     * @param string $icon
     * @param string|Renderable|string[]|Renderable[] $content
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
}
