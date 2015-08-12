<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

/**
 * Class ReadMapConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ReadMapConstraint extends EitherConstraint
{
    /**
     * Construct an instance of a ListConstraint.
     */
    public function __construct()
    {
        parent::__construct(
            new TraversableConstraint(),
            new MapConstraint()
        );
    }
}
