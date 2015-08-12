<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use ArrayAccess;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;

/**
 * Class MapConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class MapConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a ListConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new ClassTypeConstraint(ArrayAccess::class),
            new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY)
        );
    }
}
