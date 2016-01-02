<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class SetCollection.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
abstract class SetCollection extends Collection
{
    /**
     * @return AbstractTypeConstraint
     */
    public function getKeyType()
    {
        return $this->getValueType();
    }
}