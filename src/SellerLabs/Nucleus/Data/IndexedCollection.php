<?php

namespace SellerLabs\Nucleus\Data;

use SellerLabs\Nucleus\Meditation\Boa;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;

/**
 * Class IndexedCollection.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data
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