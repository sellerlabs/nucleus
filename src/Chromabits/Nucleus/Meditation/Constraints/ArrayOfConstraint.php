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

use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;

/**
 * Class ArrayOfConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ArrayOfConstraint extends LeftFoldableOfConstraint
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
