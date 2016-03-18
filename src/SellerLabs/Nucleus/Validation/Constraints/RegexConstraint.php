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

use SellerLabs\Nucleus\Meditation\Constraints\AbstractConstraint;

/**
 * Class RegexConstraint.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Validation\Constraints
 */
class RegexConstraint extends AbstractConstraint
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * Construct an instance of a RegexConstraint.
     *
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        parent::__construct();

        $this->pattern = $pattern;
    }

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
        return preg_match($this->pattern, $value) === 1;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return '{regex}';
    }
}
