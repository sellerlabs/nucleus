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

use SellerLabs\Nucleus\Data\Interfaces\FunctorInterface;
use Traversable;

/**
 * Class TraversableConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation\Constraints
 */
class FunctorConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a TraversableConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new ClassTypeConstraint(FunctorInterface::class),
            new EitherConstraint(
                new ListConstraint(),
                new ClassTypeConstraint(Traversable::class)
            )
        );
    }
}
