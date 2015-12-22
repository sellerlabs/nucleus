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
 * Class InArrayConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class InArrayConstraint extends AbstractConstraint
{
    /**
     * @var array
     */
    protected $allowed;

    /**
     * @return array
     */
    public function getAllowed()
    {
        return $this->allowed;
    }

    /**
     * Construct an instance of a InArrayConstraint.
     *
     * @param array $allowed
     */
    public function __construct(array $allowed)
    {
        parent::__construct();

        $this->allowed = $allowed;
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
        return in_array($value, $this->allowed, true);
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return 'InArrayConstraint';
    }
}
