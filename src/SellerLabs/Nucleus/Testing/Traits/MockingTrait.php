<?php

namespace SellerLabs\Nucleus\Testing\Traits;

use Mockery;
use Mockery\Matcher\Type;
use Mockery\MockInterface;

/**
 * Trait MockingTrait.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Testing\Traits
 */
trait MockingTrait
{
    /**
     * Shortcut for Mockery.
     *
     * @param string $type
     *
     * @return MockInterface
     */
    public function mock($type)
    {
        return Mockery::mock($type);
    }

    /**
     * Shortcut for Mockery's Type Matcher.
     *
     * @param string $type
     *
     * @return Type
     */
    public function matchType($type)
    {
        return Mockery::type($type);
    }
}