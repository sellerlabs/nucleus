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

/**
 * Class ExampleC.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Testing\ExampleService
 */
class ExampleC
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
     */
    public function __construct(
        ExampleAInterface $one,
        ExampleA $two
    ) {
        $this->one = $one;
        $this->two = $two;
    }

    /**
     * Get one.
     *
     * @return ExampleAInterface
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * Get two.
     *
     * @return ExampleA
     */
    public function getTwo()
    {
        return $this->two;
    }
}
