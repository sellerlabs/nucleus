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
     * @param array $context
     *
     * @return mixed
     */
    abstract public function check($value, array $context = []);

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

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'The value is expected to meet the constraint.';
    }
}
