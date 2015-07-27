<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Meditation\Exceptions\UnknownTypeException;
use Chromabits\Nucleus\Meditation\TypeHound;

/**
 * Class PrimitiveTypeConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class PrimitiveTypeConstraint extends AbstractTypeConstraint
{
    /**
     * Construct an instance of a PrimitiveConstant.
     *
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        // TODO: Validate the typeName field

        $this->expectedType = $typeName;
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return mixed
     * @throws UnknownTypeException
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
