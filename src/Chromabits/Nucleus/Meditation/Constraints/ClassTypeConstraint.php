<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class ClassTypeConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ClassTypeConstraint extends AbstractConstraint
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
     *
     * @return mixed
     */
    public function check($value)
    {
        return is_a($value, $this->className, false);
    }
}
