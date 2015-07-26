<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class EitherConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class EitherConstraint extends AbstractConstraint
{
    /**
     * First type.
     *
     * @var AbstractConstraint
     */
    protected $one;

    /**
     * Second type.
     *
     * @var AbstractConstraint
     */
    protected $other;

    /**
     * Construct an instance of an EitherConstraint.
     *
     * @param AbstractConstraint $one
     * @param AbstractConstraint $other
     */
    public function __construct(
        AbstractConstraint $one,
        AbstractConstraint $other
    ) {
        $this->one = $one;
        $this->other = $other;
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function check($value)
    {
        return truthy(
            $this->one->check($value),
            $this->other->check($value)
        );
    }
}
