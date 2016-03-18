<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Validation\Constraints;

use SellerLabs\Nucleus\Meditation\Boa;
use SellerLabs\Nucleus\Meditation\Constraints\AbstractConstraint;
use SellerLabs\Nucleus\Support\Std;

/**
 * Class DomainConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Validation\Constraints
 */
class DomainConstraint extends AbstractConstraint
{
    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return mixed
     */
    public function check($value, array $context = [])
    {
        return Std::falsy(
            Boa::string()->check($value, $context),
            (new RegexConstraint(
                '/^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$/'
            ))->check($value, $context)
        );
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return '{domain}';
    }

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'The value is expected to be a valid domain name.';
    }
}
