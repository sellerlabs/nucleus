<?php

namespace Chromabits\Nucleus\Testing\Mocking;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class CallExpectation.
 *
 * A simple structure modeling a method call expectation.
 * 
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Mocking
 */
class CallExpectation extends BaseObject
{
    /**
     * @var string
     */
    protected $methodName;
    
    /**
     * @var array
     */
    protected $arguments;
    
    /**
     * @var mixed|null
     */
    protected $return;
    
    /**
     * @var int
     */
    protected $times;

    /**
     * Construct an instance of a CallExpectation.
     *
     * @param string $methodName
     * @param array $arguments
     * @param mixed|null $return
     * @param int $times
     * 
     * @throws LackOfCoffeeException
     */
    public function __construct(
        $methodName,
        array $arguments,
        $return = null,
        $times = 1
    ) {
        parent::__construct();
        
        $this->methodName = $methodName;
        $this->arguments = $arguments;
        $this->return = $return;
        $this->times = $times;
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return mixed|null
     */
    public function getReturn()
    {
        return $this->return;
    }

    /**
     * @return int
     */
    public function getTimes()
    {
        return $this->times;
    }
}