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

    /**
     * Return whether the constraint is defined by an union of types.
     *
     * @return bool
     */
    public function isUnion()
    {
        return false;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    abstract public function toString();

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->toString();
    }
}
