<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Meditation\Constraints;

use ArrayAccess;
use SellerLabs\Nucleus\Data\Interfaces\MapInterface;

/**
 * Class MapConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation\Constraints
 */
class MapConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a MapConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new ClassTypeConstraint(MapInterface::class),
            new EitherConstraint(
                new ListConstraint(),
                new ClassTypeConstraint(ArrayAccess::class)
            )
        );
    }
}
