<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Primitives\SpecialTypes;

/**
 * Class MaybeConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class MaybeConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a MaybeConstraint.
     *
     * @param AbstractConstraint $other
     */
    public function __construct(AbstractConstraint $other)
    {
        parent::__construct(
            $other,
            new PrimitiveTypeConstraint(SpecialTypes::SPECIAL_NULL)
        );
    }

    /**
     * Construct an instance of a MaybeConstraint.
     *
     * @param AbstractConstraint $other
     *
     * @return static
     */
    public static function forType(AbstractConstraint $other)
    {
        return new static($other);
    }
}
