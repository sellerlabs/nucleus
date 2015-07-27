<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class ClassTypeConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ClassTypeConstraint extends AbstractTypeConstraint
{
    /**
     * Expected class name.
     *
     * @var string
     */
    protected $className;

    /**
     * Construct an instance of a ClassTypeConstraint.
     *
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return mixed
     */
    public function check($value, array $context = [])
    {
        return is_a($value, $this->className, false);
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return $this->className;
    }
}
