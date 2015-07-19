<?php

namespace Tests\Chromabits\Nucleus\Testing\ExampleService;

/**
 * Class ExampleD
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing\ExampleService
 */
class ExampleD
{
    /**
     * @var ExampleAInterface
     */
    protected $one;

    /**
     * @var ExampleA
     */
    protected $two;

    /**
     * Construct an instance of a ExampleC.
     *
     * @param ExampleAInterface $one
     * @param ExampleA $two
     * @param $three
     */
    public function __construct(
        ExampleAInterface $one,
        ExampleA $two,
        $three
    ) {
        $this->one = $one;
        $this->two = $two;
    }
}
