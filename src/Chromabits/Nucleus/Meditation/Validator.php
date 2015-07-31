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

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

/**
 * Class Validator.
 *
 * An extension of Spec, which supports displaying more user-friendly messages.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class Validator extends BaseObject
{
    protected $messages;

    /**
     * @var Spec
     */
    protected $spec;

    /**
     * Construct an instance of a Validator.
     *
     * @param Spec $spec
     * @param array $messages
     */
    public function __construct(Spec $spec, array $messages = [])
    {
        parent::__construct();

        $this->spec = $spec;
        $this->messages = $messages;
    }

    /**
     * Construct an instance of a Validator.
     *
     * @param Spec $spec
     * @param array $messages
     *
     * @return static
     */
    public static function create(Spec $spec, array $messages = [])
    {
        return new static($spec, $messages);
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
                        Arr::dotGet(
                            $this->messages,
                            Std::nonempty($path, $key)
                        ),
                        Std::firstBias(
                            $value instanceof AbstractConstraint,
                            function () use ($value) {
                                /* @var AbstractConstraint $value */
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
