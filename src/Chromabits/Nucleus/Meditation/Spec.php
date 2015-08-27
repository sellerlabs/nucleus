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

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Interfaces\CheckableInterface;
use Chromabits\Nucleus\Support\Std;

/**
 * Class Spec.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class Spec extends BaseObject implements CheckableInterface
{
    /**
     * @var array|\array[]|Constraints\AbstractConstraint[]
     */
    protected $constraints;

    /**
     * @var array
     */
    protected $defaults;

    /**
     * @var array
     */
    protected $required;

    /**
     * Construct an instance of a Spec.
     *
     * @param array[]|AbstractConstraint[] $constraints
     * @param array $defaults
     * @param array $required
     */
    public function __construct(
        array $constraints = [],
        array $defaults = [],
        array $required = []
    ) {
        parent::__construct();

        $this->constraints = $constraints;
        $this->defaults = $defaults;
        $this->required = $required;
    }

    /**
     * Construct an instance of a Spec.
     *
     * @param array $constraints
     * @param array $defaults
     * @param array $required
     *
     * @return static
     */
    public static function define(
        array $constraints = [],
        array $defaults = [],
        array $required = []
    ) {
        return new static($constraints, $defaults, $required);
    }

    /**
     * Check that a certain input passes the spec.
     *
     * @param mixed $input
     *
     * @return SpecResult
     */
    public function check(array $input)
    {
        $input = array_merge($this->defaults, (array) $input);

        $missing = [];
        $invalid = [];

        $check = function ($constraint, $key, $value, $input) use (
            &$missing,
            &$invalid
        ) {
            if ($constraint instanceof AbstractConstraint) {
                if (!$constraint->check($value, $input)) {
                    $invalid[$key][] = $constraint;
                }
            } elseif ($constraint instanceof CheckableInterface) {
                $result = $constraint->check($value);

                $missing = Std::concat(
                    $missing,
                    array_map(function ($subKey) use ($key) {
                        return vsprintf('%s.%s', [$key, $subKey]);
                    }, $result->getMissing())
                );

                foreach ($result->getFailed() as $failedField => $constraints) {
                    $fullPath = vsprintf('%s.%s', [$key, $failedField]);

                    if (array_key_exists($fullPath, $invalid)) {
                        $invalid[$fullPath] = array_merge(
                            $invalid[$fullPath],
                            $constraints
                        );
                    } else {
                        $invalid[$fullPath] = $constraints;
                    }
                }
            } else {
                throw new CoreException(vsprintf(
                    'Unexpected constraint type: %s.',
                    [
                        TypeHound::fetch($constraint),
                    ]
                ));
            }
        };

        array_map(function ($required) use ($input, &$missing) {
            if (!array_key_exists($required, $input)) {
                $missing[] = $required;
            }
        }, $this->required);

        array_map(function ($key, $value) use ($input, &$invalid, $check) {
            if (!array_key_exists($key, $this->constraints)) {
                return;
            }

            if (is_array($this->constraints[$key])) {
                array_map(function ($constraint) use (
                    $key,
                    $value,
                    $input,
                    &$invalid,
                    $check
                ) {
                    $check($constraint, $key, $value, $input);
                }, $this->constraints[$key]);

                return;
            }

            /** @var AbstractConstraint $constraint */
            $constraint = $this->constraints[$key];
            $check($constraint, $key, $value, $input);
        }, array_keys($input), $input);

        if (count($missing) === 0 && count($invalid) === 0) {
            return new SpecResult($missing, $invalid, SpecResult::STATUS_PASS);
        }

        return new SpecResult($missing, $invalid, SpecResult::STATUS_FAIL);
    }

    /**
     * @return array|array[]|AbstractConstraint[]
     */
    public function getConstraints()
    {
        return $this->constraints;
    }

    /**
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }
}
