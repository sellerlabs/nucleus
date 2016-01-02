<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Transformation;

use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\Transformation\Interfaces\TransformInterface;
use Closure;

/**
 * Class ClosureTransform.
 *
 * A transform that wraps a closure.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class ClosureTransform implements TransformInterface
{
    /**
     * @var Closure
     */
    protected $inner;

    /**
     * Construct an instance of a ClosureTransform.
     *
     * @param Closure $inner
     */
    public function __construct(Closure $inner)
    {
        $this->inner = $inner;
    }

    /**
     * Execute the transform.
     *
     * @param array $input
     *
     * @return array
     */
    public function run(array $input)
    {
        return Std::call($this->inner, $input);
    }
}
