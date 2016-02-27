<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Exceptions;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\SpecResult;
use Exception;

/**
 * Class InvalidAttributesException.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Exceptions
 */
class InvalidAttributesException extends CoreException
{
    /**
     * @var SpecResult
     */
    protected $specResult;

    /**
     * Construct the exception.
     *
     * @param SpecResult $checkableResult
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for
     * the exception chaining.
     */
    public function __construct(
        SpecResult $checkableResult,
        $message = 'Invalid attributes were provided.',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous
        );

        $this->specResult = $checkableResult;
    }

    /**
     * Get the spec result for attributes.
     *
     * @return SpecResult
     */
    public function getSpecResult()
    {
        return $this->specResult;
    }
}
