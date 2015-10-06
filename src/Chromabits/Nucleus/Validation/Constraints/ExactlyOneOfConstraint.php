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

/**
 * Class ExactlyOneOfConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation\Constraints
 */
class ExactlyOneOfConstraint extends AtLeastOneOfConstraint
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
        $count = 0;

        foreach ($context as $field => $value) {
            if (in_array($field, $this->fields)) {
                $count++;
            }
        }

        return ($count === 1);
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return vsprintf(
            '{exactlyOneOf: ["%s"]}',
            [implode('", "', $this->fields)]
        );
    }

    /**
     * Get a description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return vsprintf(
            'Only one of the following should be provided: ["%s"]}',
            [implode('", "', $this->fields)]
        );
    }
}
