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

use Chromabits\Nucleus\Support\Std;

/**
 * Class EitherConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class EitherConstraint extends AbstractTypeConstraint
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
        parent::__construct();

        $this->one = $one;
        $this->other = $other;
    }

    /**
     * Construct an instance of an EitherConstraint.
     *
     * @param AbstractConstraint $one
     * @param AbstractConstraint $other
     *
     * @return static
     */
    public static function create(
        AbstractConstraint $one,
        AbstractConstraint $other
    ) {
        return new static($one, $other);
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return bool
     */
    public function check($value, array $context = [])
    {
        return Std::truthy(
            $this->one->check($value),
            $this->other->check($value)
        );
    }

    /**
     * Return whether the constraint is defined by an union of types.
     *
     * @return bool
     */
    public function isUnion()
    {
        return true;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        $one = $this->one->toString();
        $other = $this->other->toString();

        if ($this->one instanceof AbstractTypeConstraint) {
            $one = $this->one->isUnion() ? sprintf('(%s)', $one) : $one;
        }

        if ($this->other instanceof AbstractTypeConstraint) {
            $other = $this->other->isUnion() ? sprintf('(%s)', $other) : $other;
        }

        return sprintf('%s|%s', $one, $other);
    }
}
