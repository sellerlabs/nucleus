<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Traversable;

/**
 * Class TraversableConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class TraversableConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a TraversableConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new ClassTypeConstraint(Traversable::class),
            new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY)
        );
    }
}
