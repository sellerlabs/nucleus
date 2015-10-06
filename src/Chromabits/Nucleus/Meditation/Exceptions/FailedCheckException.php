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
use Chromabits\Nucleus\Meditation\Interfaces\CheckableInterface;
use Chromabits\Nucleus\Meditation\Interfaces\CheckResultInterface;
use Exception;

/**
 * Class FailedSpecException.
 *
 * Thrown when a check fails (most commonly a Spec or Validator). This
 * exception is available for cases when it is useful to raise the failed
 * status of a check into an exception, however, Spec/Validators won't throw
 * by default whenever a check fails.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Exceptions
 */
class FailedCheckException extends CoreException
{
    /**
     * @var CheckableInterface
     */
    protected $checkable;

    /**
     * @var CheckResultInterface
     */
    protected $result;

    /**
     * Construct an instance of a FailedCheckException.
     *
     * @param CheckableInterface $checkable
     * @param CheckResultInterface $result
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(
        CheckableInterface $checkable,
        CheckResultInterface $result,
        $message = '',
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->checkable = $checkable;
        $this->result = $result;
    }

    /**
     * Get the class used to check the failed input.
     *
     * @return CheckableInterface
     */
    public function getCheckable()
    {
        return $this->checkable;
    }

    /**
     * Get the result of the check operation.
     *
     * @return CheckResultInterface
     */
    public function getResult()
    {
        return $this->result;
    }
}
