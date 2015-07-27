<?php

namespace Chromabits\Nucleus\Views\Interfaces;

/**
 * Interface Renderable
 *
 * Represents an object that can be rendered into a string.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Views\Interfaces
 */
interface Renderable
{
    /**
     * Render the object into a string.
     *
     * @return mixed
     */
    public function render();
}
