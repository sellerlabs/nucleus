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

use Chromabits\Nucleus\Exceptions\CoreException;
use Exception;

/**
 * Class UnknownTypeException.
 *
 * Thrown when a type is unknown.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Exceptions
 */
class UnknownTypeException extends CoreException
{
    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Construct the exception. Note: The message is NOT binary safe.
     *
     * @link http://php.net/manual/en/exception.construct.php
     *
     * @param string $typeName The name of the type that is unknown.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for
     * the exception chaining.
     */
    public function __construct(
        $typeName,
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct(
            sprintf('The type %s is unknown.', $typeName),
            $code,
            $previous
        );
    }
}
