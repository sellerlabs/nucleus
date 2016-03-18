<?php

namespace SellerLabs\Nucleus\Data;

use SellerLabs\Nucleus\Meditation\Constraints\AbstractTypeConstraint;

/**
 * Class SetCollection.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Data
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