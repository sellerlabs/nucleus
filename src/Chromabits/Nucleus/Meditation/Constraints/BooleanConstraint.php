<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Strings\Rope;

/**
 * Class BooleanConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class BooleanConstraint extends AbstractConstraint
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
        if (is_string($value) || $value instanceof Rope) {
            $lower = Rope::of($value)->toLower();

            return $lower->equals(Rope::of('true'))
                || $lower->equals(Rope::of('false'));
        } elseif (is_int($value)) {
            return $value === 0 || $value === 1;
        } elseif (is_float($value)) {
            return $value === 0.0 || $value === 1.0;
        }

        return is_bool($value);
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return '{boolean}';
    }

    /**
     * @inheritDoc
     */
    public function getDescription()
    {
        return 'The value is expected to be boolean-like: ' .
            '0, 1, 0.0, 1.0, true, false, True, False';
    }
}
