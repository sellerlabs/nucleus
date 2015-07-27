<?php

namespace Chromabits\Nucleus\View\Interfaces;

/**
 * Interface Renderable
 *
 * Represents an object that can be rendered into a string.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Interfaces
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
