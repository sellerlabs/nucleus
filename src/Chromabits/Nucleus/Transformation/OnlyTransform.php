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

use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Transformation\Interfaces\TransformInterface;

/**
 * Class OnlyTransform.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support\Transforms
 */
class OnlyTransform extends BaseObject implements TransformInterface
{
    /**
     * @var string[]
     */
    protected $allowed;

    /**
     * Construct an instance of a OnlyTransform.
     *
     * @param array $allowed
     */
    public function __construct(array $allowed)
    {
        parent::__construct();

        Arguments::define(Boa::arrOf(Boa::string()))->check($allowed);

        $this->allowed = $allowed;
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
        return ArrayMap::of($input)->only($this->allowed)->toArray();
    }
}
