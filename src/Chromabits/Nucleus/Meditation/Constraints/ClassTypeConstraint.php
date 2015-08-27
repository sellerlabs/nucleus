<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class ClassTypeConstraint.
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
        parent::__construct();

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

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return vsprintf('The value is expected to be an instance of a %s.', [
            $this->className,
        ]);
    }
}
