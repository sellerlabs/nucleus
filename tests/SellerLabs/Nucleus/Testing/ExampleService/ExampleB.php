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
 * Class ExampleB.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Testing\ExampleService
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
