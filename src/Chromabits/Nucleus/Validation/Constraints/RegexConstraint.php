<?php

namespace Chromabits\Nucleus\Validation\Constraints;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;

/**
 * Class RegexConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation\Constraints
 */
class RegexConstraint extends AbstractConstraint
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * Construct an instance of a RegexConstraint.
     *
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        parent::__construct();

        $this->pattern = $pattern;
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
        return preg_match($this->pattern, $value) === true;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return '{regex}';
    }
}
