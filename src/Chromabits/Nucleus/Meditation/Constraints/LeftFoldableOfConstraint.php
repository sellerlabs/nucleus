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

/**
 * Class TraversableOfConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class LeftFoldableOfConstraint extends AbstractConstraint
{
    /**
     * @var AbstractConstraint
     */
    protected $valueConstraint;

    /**
     * Construct an instance of a TraversableOfConstraint.
     *
     * @param AbstractConstraint $valueConstraint
     */
    public function __construct(AbstractConstraint $valueConstraint)
    {
        parent::__construct();

        $this->valueConstraint = $valueConstraint;
    }

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
        return (new LeftFoldableConstraint())->check($value, $context);
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return mixed
     */
    public function check($value, array $context = [])
    {
        if ($this->checkContainerType($value, $context) === false) {
            return false;
        }

        foreach ($value as $item) {
            if ($this->valueConstraint->check($item, $context) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return string
     */
    public function toString()
    {
        return vsprintf(
            'Traversable<%s>',
            [$this->valueConstraint->toString()]
        );
    }
}
