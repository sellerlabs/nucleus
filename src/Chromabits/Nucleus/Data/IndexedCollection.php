<?php

namespace Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;

/**
 * Class IndexedCollection.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data
 */
abstract class IndexedCollection extends Collection
{
    /**
     * @return PrimitiveTypeConstraint
     */
    public function getKeyType()
    {
        return Boa::integer();
    }
}