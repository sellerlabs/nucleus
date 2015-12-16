<?php

namespace Chromabits\Nucleus\Testing\Mocking;

/**
 * Class CallAndThrowExpectation.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Mocking
 */
class CallAndThrowExpectation extends CallExpectation
{
    /**
     * @var mixed|null
     */
    protected $exceptionClass;

    /**
     * @var string
     */
    protected $exceptionMessage;

    /**
     * @var int
     */
    protected $exceptionCode;

    /**
     * Construct an instance of a CallAndThrowExpectation.
     * 
     * @param string $methodName
     * @param array $arguments
     * @param mixed|null $exceptionClass
     * @param string $exceptionMessage
     * @param int $exceptionCode
     */
    public function __construct(
        $methodName, 
        array $arguments, 
        $exceptionClass, 
        $exceptionMessage = '', 
        $exceptionCode = 0
    ) {
        parent::__construct($methodName, $arguments, null, 1);
        
        $this->exceptionClass = $exceptionClass;
        $this->exceptionMessage = $exceptionMessage;
        $this->exceptionCode = $exceptionCode;
    }

    /**
     * @return mixed|null
     */
    public function getExceptionClass()
    {
        return $this->exceptionClass;
    }

    /**
     * @return string
     */
    public function getExceptionMessage()
    {
        return $this->exceptionMessage;
    }

    /**
     * @return int
     */
    public function getExceptionCode()
    {
        return $this->exceptionCode;
    }
}