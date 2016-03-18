<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Meditation\Interfaces;

use SellerLabs\Nucleus\Meditation\SpecResult;

/**
 * Interface CheckableInterface.
 *
 * Describes an object that can be checked against a set of constraints (a
 * specification) and return a result describing the result of the computation.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation\Interfaces
 */
interface CheckableInterface
{
    /**
     * Check that a certain input passes the spec or constraint collection.
     *
     * @param mixed $input
     *
     * @return SpecResult
     */
    public function check(array $input);
}
