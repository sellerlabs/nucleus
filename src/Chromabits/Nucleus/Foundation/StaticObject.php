<?php

namespace Chromabits\Nucleus\Foundation;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;

/**
 * Class StaticObject
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Foundation
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
