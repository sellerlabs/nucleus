<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Testing\ExampleService;

use SellerLabs\Nucleus\Strings\Rope;

/**
 * Class ExampleA.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Testing\ExampleService
 */
class ExampleA extends ExampleBase implements ExampleAInterface
{
    /**
     * Says hello.
     *
     * @return Rope
     */
    public function sayHello()
    {
        return Rope::of('hello there');
    }
}
