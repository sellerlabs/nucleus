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

/**
 * Class ReadMapConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation\Constraints
 */
class ReadMapConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a ListConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new LeftFoldableConstraint(),
            new MapConstraint()
        );
    }
}
