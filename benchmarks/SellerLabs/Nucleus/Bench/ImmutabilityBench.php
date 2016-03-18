<?php

namespace Benchmarks\SellerLabs\Nucleus\Bench;

use SellerLabs\Nucleus\Bench\ExampleImmutable;
use SellerLabs\Nucleus\Bench\ExampleMutable;

/**
 * Class ImmutabilityBench.
 *
 * @Revs(1000)
 * @Iterations(20)
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Benchmarks\SellerLabs\Nucleus\Bench
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

    public function benchMutableChain()
    {
        $instance = new ExampleMutable();

        $instance
            ->mutate()
            ->mutate()
            ->mutate()
            ->mutate()
            ->mutate();
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

    public function benchImmutableChain()
    {
        $instance = new ExampleImmutable();

        $instance
            ->mutate()
            ->mutate()
            ->mutate()
            ->mutate()
            ->mutate();
    }
}