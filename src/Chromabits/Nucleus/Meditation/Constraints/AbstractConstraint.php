<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class AbstractConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
abstract class AbstractConstraint
{
    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    abstract public function check($value);
}
