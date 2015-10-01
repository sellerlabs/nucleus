<?php

namespace Chromabits\Nucleus\Support\Transforms;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Support\Interfaces\TransformInterface;
use Illuminate\Support\Arr;

/**
 * Class OnlyTransform
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

        Arguments::contain(Boa::arrOf(Boa::string()))->check($allowed);

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
        return Arr::only($input, $this->allowed);
    }
}