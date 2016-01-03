<?php

namespace Benchmarks\Chromabits\Nucleus\Bench;
use Chromabits\Nucleus\Bench\ExampleImmutable;
use Chromabits\Nucleus\Bench\ExampleMutable;

/**
 * Class ImmutabilityBench.
 *
 * @Revs(1000)
 * @Iterations(20)
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Benchmarks\Sanity
 */
class ImmutabilityBench
{
    public function benchMutable()
    {
        $instance = new ExampleMutable();

        for ($ii = 0; $ii < 200; $ii++) {
            $instance = $instance->mutate();
        }
    }

    public function benchMutableWithoutAssign()
    {
        $instance = new ExampleMutable();

        for ($ii = 0; $ii < 200; $ii++) {
            $instance->mutate();
        }
    }

    public function benchImmutable()
    {
        $instance = new ExampleImmutable();

        for ($ii = 0; $ii < 200; $ii++) {
            $instance = $instance->mutate();
        }
    }
}