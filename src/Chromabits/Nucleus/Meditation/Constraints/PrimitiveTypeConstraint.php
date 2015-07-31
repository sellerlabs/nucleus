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

use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Meditation\TypeHound;

/**
 * Class PrimitiveTypeConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class PrimitiveTypeConstraint extends AbstractTypeConstraint
{
    protected $expectedType;

    /**
     * Construct an instance of a PrimitiveConstant.
     *
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        parent::__construct();

        // TODO: Validate the typeName field

        $this->expectedType = $typeName;
    }

    /**
     * Construct an instance of a PrimitiveConstant.
     *
     * @param string $typeName
     *
     * @return static
     */
    public static function forType($typeName)
    {
        return new static($typeName);
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @throws UnknownTypeException
     * @return mixed
     */
    public function check($value, array $context = [])
    {
        $hound = new TypeHound($value);

        return $this->expectedType === $hound->resolve();
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return $this->expectedType;
    }
}
