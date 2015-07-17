<?php

namespace Chromabits\Nucleus\Exceptions;

use Exception;

/**
 * Class LackOfCoffeeException
 *
 * We all have that day. This should be thrown when a programmer error or
 * mistake is detected.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Exceptions
 */
class LackOfCoffeeException extends CoreException
{
    const DEFAULT_PREFIX = "(╯°□°）╯︵ ┻━┻";

    /**
     * Construct an instance of a LackOfCoffeeException.
     *
     * @param string $message
     * @param int $code
     * @param Exception|null $previous
     */
    public function __construct(
        $message = "",
        $code = 0,
        Exception $previous = null
    ) {
        if ($message == "") {
            $message = static::DEFAULT_PREFIX . ' Coffee time!';
        } else {
            $message = static::DEFAULT_PREFIX . ' ' . $message;
        }

        parent::__construct($message, $code, $previous);
    }
}
