<?php

namespace Chromabits\Nucleus\Support\Abstractors;

use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class AbstractAbstractor
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support\Abstractors
 */
abstract class AbstractAbstractor extends BaseObject
{
    /**
     * Get a list of names of the types this abstractor can work on.
     *
     * @return array
     */
    abstract public function getAbstractedTypes();
}
