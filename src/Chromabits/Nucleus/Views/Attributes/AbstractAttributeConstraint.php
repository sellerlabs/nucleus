<?php

namespace Chromabits\Nucleus\Views\Attributes;

/**
 * Class AbstractAttributeConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Views\Attributes
 */
abstract class AbstractAttributeConstraint
{
    /**
     * Check if the constraint is met.
     *
     * @param mixed $input
     *
     * @return bool
     */
    abstract public function check($input);
}
