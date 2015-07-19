<?php

namespace Tests\Chromabits\Nucleus\Testing\ExampleService;

/**
 * Class ExampleB
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing\ExampleService
 */
class ExampleB
{
    /**
     * @var ExampleAInterface
     */
    protected $exampleA;

    /**
     * Construct an instance of a ExampleB.
     *
     * @param ExampleAInterface $exampleA
     */
    public function __construct(ExampleAInterface $exampleA)
    {
        $this->exampleA = $exampleA;
    }

    /**
     * Get instance of ExampleAInterface.
     *
     * @return ExampleAInterface
     */
    public function getExampleA()
    {
        return $this->exampleA;
    }
}
