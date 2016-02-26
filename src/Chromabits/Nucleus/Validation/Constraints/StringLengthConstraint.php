<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Validation\Constraints;

use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Support\Std;

/**
 * Class StringLengthConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation\Constraints
 */
class StringLengthConstraint extends AbstractConstraint
{
    /**
     * @var int
     */
    protected $min;

    /**
     * @var int
     */
    protected $max;

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * Construct an instance of a StringLengthConstraint.
     *
     * @param int $min
     * @param int $max
     *
     * @throws InvalidArgumentException
     */
    public function __construct($min = 0, $max = -1)
    {
        parent::__construct();

        Arguments::define(Boa::integer(), Boa::integer())
            ->check($min, $max);

        if ($min < 0) {
            throw new InvalidArgumentException(
                'The minimum length is expected to be >= 0.'
            );
        }

        if (($max != -1 && $max < $min) || $max < -1) {
            throw new InvalidArgumentException('
                The maximum length is expected to be: (== -1 || >= minimum) &&'
                . ' >= -1.'
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
        $length = mb_strlen($value);

        return !Std::truthy(
            ($this->min > $length),
            ($this->max !== -1 && $this->max < $length)
        );
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        if ($this->max !== -1) {
            return vsprintf('{length: %d <= x <= %d}', [
                $this->min,
                $this->max,
            ]);
        }

        return vsprintf('{length: %d <= x}', [
            $this->min,
        ]);
    }

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        if ($this->max !== -1) {
            return vsprintf(
                'The value is expected to have a length between %d and %d'
                . ' (%d <= x <= %d).',
                [
                    $this->min,
                    $this->max,
                    $this->min,
                    $this->max,
                ]
            );
        }

        return vsprintf(
            'The value is expected to have a length greater or equal to %d'
            . ' (%d <= x).',
            [
                $this->min,
                $this->min,
            ]
        );
    }
}
