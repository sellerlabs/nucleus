<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Validation\Constraints;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;

/**
 * Class EmailConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation\Constraints
 */
class EmailConstraint extends AbstractConstraint
{
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
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return '{email}';
    }

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'The value is expected to be a valid email address.';
    }
}
