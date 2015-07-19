<?php

namespace Tests\Chromabits\Nucleus\Testing\ExampleService;

/**
 * Class ExampleA
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Testing\ExampleService
 */
class ExampleA extends ExampleBase implements ExampleAInterface
{
    /**
     * Says hello.
     *
     * @return \Chromabits\Nucleus\Strings\Rope
     */
    public function sayHello()
    {
        return rope('hello there');
    }
}
