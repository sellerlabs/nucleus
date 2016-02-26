<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Validation\Constraints;

use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;

/**
 * Class AtLeastOneOfConstraint.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Validation\Constraints
 */
class AtLeastOneOfConstraint extends AbstractConstraint
{
    /**
     * @var string[]
     */
    protected $fields;

    /**
     * Construct an instance of a AtLeastOneOfConstraint.
     *
     * @param array $fields
     */
    public function __construct(array $fields)
    {
        parent::__construct();

        Arguments::define(Boa::arrOf(Boa::string()))->check($fields);

        $this->fields = $fields;
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
        foreach ($context as $field => $value) {
            if (in_array($field, $this->fields)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get string representation of this constraint.
     *
     * @return mixed
     */
    public function toString()
    {
        return vsprintf(
            '{atLeastOneOf: ["%s"]}',
            [implode('", "', $this->fields)]
        );
    }

    /**
     * Get a description of the constraint.
     *
     * @return string
     */
    public function getDescription()
    {
        return vsprintf(
            'At least one of the following fields should be provided: ["%s"]}',
            [implode('", "', $this->fields)]
        );
    }
}
