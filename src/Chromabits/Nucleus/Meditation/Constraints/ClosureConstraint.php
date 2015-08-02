<?php

namespace Chromabits\Nucleus\Meditation\Constraints;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\Support\Std;
use Closure;

/**
 * Class ClosureConstraint
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Constraints
 */
class ClosureConstraint extends AbstractConstraint
{
    protected $closure;

    protected $description;

    /**
     * Construct an instance of a ClosureConstraint.
     *
     * @param Closure $closure
     * @param null $description
     */
    public function __construct(Closure $closure, $description = null)
    {
        parent::__construct();

        $this->closure = $closure;
        $this->description = Std::coalesce(
            $description,
            'The value is expected to meet the constraint.'
        );
    }

    /**
     * Check if the constraint is met.
     *
     * @param mixed $value
     * @param array $context
     *
     * @return mixed
     * @throws LackOfCoffeeException
     */
    public function check($value, array $context = [])
    {
        $closure = $this->closure;
        $result = $closure($value, $context);

        if (!is_bool($result)) {
            throw new LackOfCoffeeException(
                vsprintf(
                    'Inner closure of constraint was expected to return a'
                    . ' boolean value. Got %s instead.',
                    [TypeHound::createAndResolve($result)]
                )
            );
        }

        return $result;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return 'custom';
    }

    /**
     * Get the description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
