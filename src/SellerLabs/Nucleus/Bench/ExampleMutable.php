<?php

namespace SellerLabs\Nucleus\Bench;

use SellerLabs\Nucleus\Foundation\BaseObject;

/**
 * Class ExampleMutable.
 *
 * @internal
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Bench
 */
class ExampleMutable extends BaseObject
{
    /**
     * @var array
     */
    protected $value;

    /**
     * Construct an instance of a ExampleMutable.
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
        $this->value[] = 45;

        return $this;
    }
}