<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;

/**
 * Class BetweenConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class BetweenConstraint extends AbstractConstraint
{
    protected $min;
    protected $max;

    /**
     * Construct an instance of a BetweenConstraint.
     *
     * @param integer|float $min
     * @param integer|float $max
     *
     * @throws LackOfCoffeeException
     * @throws InvalidArgumentException
     */
    public function __construct($min, $max)
    {
        Arguments::contain(new NumericConstraint(), new NumericConstraint())
            ->check($min, $max);

        if ($min > $max) {
            throw new LackOfCoffeeException(
                'Min should be smaller than or equal to max.'
            );
        }

        $this->min = $min;
        $this->max = $max;
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
        return ($this->min <= $value && $this->max >= $value);
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return vsprintf('%f <= x <= %f', [$this->min, $this->max]);
    }

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return vsprintf(
            'The value is expected to be between %f and %f'
            . ' (%f <= x <= %f).',
            [$this->min, $this->max, $this->min, $this->max]
        );
    }
}
