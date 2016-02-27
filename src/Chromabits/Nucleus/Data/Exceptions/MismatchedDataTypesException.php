<?php

namespace Chromabits\Nucleus\Data\Exceptions;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\TypeHound;

/**
 * Class MismatchedDataTypesException
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Exceptions
 */
class MismatchedDataTypesException extends CoreException
{
    /**
     * @var string
     */
    protected $expected;

    /**
     * @var string
     */
    protected $received;

    /**
     * Construct an instance of a MismatchedDataTypesException.
     *
     * @param string|object $expected
     * @param mixed $received
     */
    public function __construct($expected, $received)
    {
        parent::__construct('', null, null);

        $this->setExpectedAndReceived($expected, $received);
    }

    /**
     * Static constructor.
     *
     * @param string|object $expected
     * @param mixed $received
     *
     * @return MismatchedDataTypesException
     */
    public static function create($expected, $received)
    {
        return new MismatchedDataTypesException($expected, $received);
    }

    /**
     * Set the expected class and the received value.
     *
     * @param string|object $expected
     * @param mixed $received
     */
    public function setExpectedAndReceived($expected, $received)
    {
        $this->expected = is_string($expected)
            ? $expected : get_class($expected);

        $this->received = TypeHound::fetch($received);

        $this->message = vsprintf(
            'An instance of a %s was expected but got %s',
            [$this->expected, $this->received]
        );
    }

    /**
     * @return string
     */
    public function getExpected()
    {
        return $this->expected;
    }

    /**
     * @return string
     */
    public function getReceived()
    {
        return $this->received;
    }
}
