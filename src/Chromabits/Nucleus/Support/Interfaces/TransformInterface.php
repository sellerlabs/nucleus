<?php

namespace Chromabits\Nucleus\Support\Interfaces;

/**
 * Interface TransformInterface
 *
 * A class capable of transforming an array in some way.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support\Interfaces
 */
interface TransformInterface
{
    /**
     * Execute the transform.
     *
     * @param array $input
     *
     * @return array
     */
    public function run(array $input);
}