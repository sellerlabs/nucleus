<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Validation;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Interfaces\CheckableInterface;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Meditation\SpecResult;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

/**
 * Class Validator.
 *
 * An extension of Spec, which supports displaying more user-friendly messages.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation
 */
class Validator extends BaseObject implements CheckableInterface
{
    /**
     * @var array
     */
    protected $messages;

    /**
     * @var Spec
     */
    protected $spec;

    /**
     * Construct an instance of a Validator.
     *
     * @param CheckableInterface $spec
     * @param array $messages
     */
    public function __construct(CheckableInterface $spec, array $messages = [])
    {
        parent::__construct();

        $this->spec = $spec;
        $this->messages = $messages;
    }

    /**
     * Construct an instance of a Validator.
     *
     * @param CheckableInterface $spec
     * @param array $messages
     *
     * @return static
     * @deprecated
     */
    public static function create(
        CheckableInterface $spec,
        array $messages = []
    ) {
        return new static($spec, $messages);
    }

    /**
     * Construct an instance of a Validator.
     *
     * @param CheckableInterface $spec
     * @param array $messages
     *
     * @return static
     */
    public static function define(
        CheckableInterface $spec,
        array $messages = []
    ) {
        return new static($spec, $messages);
    }

    /**
     * Shortcut for defining a validator using a Spec.
     *
     * @param array $constraints
     * @param array $defaults
     * @param array $required
     * @param array $messages
     *
     * @return static
     */
    public static function spec(
        $constraints,
        $defaults = [],
        $required = [],
        $messages = []
    ) {
        return new static(
            Spec::define($constraints, $defaults, $required),
            $messages
        );
    }

    /**
     * @return string[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return Spec
     */
    public function getSpec()
    {
        return $this->spec;
    }

    /**
     * Check that the spec matches and overlay help messaged.
     *
     * The resulting SpecResult instance should have more user-friendly
     * messages. This allows one to use Specs for validation on a website or
     * even an API.
     *
     * @param array $input
     *
     * @return SpecResult
     */
    public function check(array $input)
    {
        $result = $this->spec->check($input);

        return new SpecResult(
            $result->getMissing(),
            Arr::walkCopy(
                $result->getFailed(),
                function ($key, $value, &$array, $path) {
                    $array[$key] = Std::coalesce(
                        Std::firstBias(
                            Arr::dotGet(
                                $this->messages,
                                Std::nonempty($path, $key)
                            ) !== null,
                            [Arr::dotGet(
                                $this->messages,
                                Std::nonempty($path, $key)
                            )],
                            null
                        ),
                        Std::firstBias(
                            $value instanceof AbstractConstraint,
                            function () use ($value) {
                                return $value->getDescription();
                            },
                            null
                        ),
                        Std::firstBias(
                            is_array($value),
                            function () use ($value) {
                                return array_map(
                                    function (AbstractConstraint $item) {
                                        return $item->getDescription();
                                    },
                                    $value
                                );
                            },
                            $value
                        )
                    );
                },
                true,
                '',
                false
            ),
            $result->getStatus()
        );
    }
}
