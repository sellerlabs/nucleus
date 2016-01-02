<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation\Exceptions;

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Meditation\TypeHound;

/**
 * Class MismatchedArgumentTypesException.
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
                    ArrayList::of($arguments)
                        ->map(function ($item) {
                            return TypeHound::fetch($item);
                        })
                        ->join(', '),
                    $functionName,
                ]
            )
        );
    }
}
