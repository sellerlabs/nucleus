<?php

namespace SellerLabs\Nucleus\Bench;

use SellerLabs\Nucleus\Foundation\BaseObject;

/**
 * Class ExampleImmutable.
 *
 * @internal
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Bench
 */
class ExampleImmutable extends BaseObject
{
    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ExampleImmutable.
     */
    public function __construct()
    {
        parent::__construct();

        $this->value = [];
    }

    /**
     * Perform a mutation.
     */
    public function mutate()
    {
        $copy = clone $this;

        $copy->value[] = 45;

        return $copy;
    }
}