<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;

/**
 * Class ArrayOfConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ArrayOfConstraint extends TraversableOfConstraint
{
    /**
     * Check the type of the traversable container.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return bool
     */
    protected function checkContainerType($value, $context = [])
    {
        return (new PrimitiveTypeConstraint(CompoundTypes::COMPOUND_ARRAY))
            ->check($value, $context);
    }
}
