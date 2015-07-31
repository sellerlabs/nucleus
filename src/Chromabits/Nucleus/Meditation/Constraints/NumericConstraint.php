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

use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;

/**
 * Class NumericConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class NumericConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a NumericConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER),
            new PrimitiveTypeConstraint(ScalarTypes::SCALAR_FLOAT)
        );
    }
}
