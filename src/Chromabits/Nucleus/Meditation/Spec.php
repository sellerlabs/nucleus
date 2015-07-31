<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;

/**
 * Class Spec.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class Spec
{
    protected $types;

    protected $defaults;

    protected $required;

    /**
     * Construct an instance of a Spec.
     *
     * @param array[]|AbstractConstraint[] $types
     * @param array $defaults
     * @param array $required
     */
    public function __construct(
        array $types = [],
        array $defaults = [],
        array $required = []
    ) {
        $this->types = $types;
        $this->defaults = $defaults;
        $this->required = $required;
    }

    /**
     * Construct an instance of a Spec.
     *
     * @param array $types
     * @param array $defaults
     * @param array $required
     *
     * @return static
     */
    public static function define(
        array $types = [],
        array $defaults = [],
        array $required = []
    ) {
        return new static($types, $defaults, $required);
    }

    /**
     * Check that a certain input passes the spec.
     *
     * @param mixed $input
     *
     * @return SpecResult
     */
    public function check($input)
    {
        $input = array_merge($this->defaults, (array) $input);

        $missing = [];
        $invalid = [];

        array_map(function ($required) use ($input, &$missing) {
            if (!array_key_exists($required, $input)) {
                $missing[] = $required;
            }
        }, $this->required);

        // TODO: Support recursive specs
        array_map(function ($key, $value) use ($input, &$invalid) {
            if (!array_key_exists($key, $this->types)) {
                return;
            }

            if (is_array($this->types[$key])) {
                array_map(function (
                    AbstractConstraint $constraint
                ) use ($key, $value, $input, &$invalid) {
                    if (!$constraint->check($value, $input)) {
                        $invalid[$key][] = $constraint;
                    }
                }, $this->types[$key]);

                return;
            }

            /** @var AbstractConstraint $constraint */
            $constraint = $this->types[$key];
            if (!$constraint->check($value, $input)) {
                $invalid[$key] = [$constraint];
            }
        }, array_keys($input), $input);

        if (count($missing) === 0 && count($invalid) === 0) {
            return new SpecResult($missing, $invalid, SpecResult::STATUS_PASS);
        }

        return new SpecResult($missing, $invalid, SpecResult::STATUS_FAIL);
    }
}
