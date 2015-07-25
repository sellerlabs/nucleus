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
     * @param array $input The input array can be used by the object while
     * rendering for defining how the object should look like. If a rendering
     * method is pure, that is, the render method is only altered by the input
     * array and the same input always renders the same result, then the result
     * could be potentially cached by the object.
     *
     * @return mixed
     */
    public function render(array $input);
}
