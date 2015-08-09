<?php

namespace Chromabits\Nucleus\Meditation\Exceptions;

use Chromabits\Nucleus\Meditation\TypeHound;

/**
 * Class MismatchedArgumentTypesException
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Exceptions
 */
class MismatchedArgumentTypesException extends InvalidArgumentException
{
    /**
     * Construct an instance of a MismatchedArgumentTypesException.
     *
     * @param string $functionName
     * @param mixed $arguments
     */
    public function __construct($functionName, ...$arguments)
    {
        parent::__construct(
            vsprintf(
                'Argument type mismatch: %s for function %s',
                [
                    implode(', ', array_map(function ($item) {
                        return TypeHound::fetch($item);
                    }, $arguments)),
                    $functionName
                ]
            )
        );
    }
}
