<?php

namespace SellerLabs\Nucleus\Foundation;

use SellerLabs\Nucleus\Exceptions\LackOfCoffeeException;

/**
 * Class StaticObject
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Foundation
 */
class StaticObject extends BaseObject
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct();

        throw new LackOfCoffeeException(vsprintf(
            'The constructor of %s was called, but this is declared as'
            . ' static.',
            [static::class]
        ));
    }
}
