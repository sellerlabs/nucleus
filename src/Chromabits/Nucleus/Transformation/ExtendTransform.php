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

use Chromabits\Nucleus\Transformation\Interfaces\TransformInterface;

/**
 * Class ExtendTransform.
 *
 * A transform that takes the input and merges it with another array. The
 * provided array can override the input fields, hence the name extension.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support\Transforms
 */
class ExtendTransform implements TransformInterface
{
    /**
     * @var array
     */
    protected $extension;

    /**
     * Construct an instance of a ExtendTransform.
     *
     * @param array $extension
     */
    public function __construct(array $extension)
    {
        $this->extension = $extension;
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
        return array_merge($input, $this->extension);
    }
}
