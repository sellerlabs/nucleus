<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

/**
 * Class Validator
 *
 * An extension of Spec, which supports displaying more user-friendly messages.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class Validator
{
    protected $messages;

    /**
     * @var Spec
     */
    protected $spec;

    /**
     * Construct an instance of
     * @param Spec $spec
     * @param array $messages
     */
    public function __construct(Spec $spec, array $messages)
    {
        $this->spec = $spec;
        $this->messages = $messages;
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
                                /** @var AbstractConstraint $value */
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
