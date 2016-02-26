<?php

namespace Chromabits\Nucleus\Bench;

use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class ExampleMutable.
 *
 * @internal
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Bench
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