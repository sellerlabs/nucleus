<?php

/**
 * Copyright 2015, Eduardo Trujillo
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Control\Maybe;
use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Data\ArrayMap;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\Exceptions\MismatchedArgumentTypesException;

/**
 * Class SpecFactory.
 * A utility class for fluently defining Specs.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecFactory extends BaseObject
{
    /**
     * Name of the field reserved for global-like constraints.
     */
    const FIELD_SELF = '*';

    /**
     * @var ArrayMap
     */
    protected $constraints;

    /**
     * @var ArrayMap
     */
    protected $defaults;

    /**
     * @var ArrayList
     */
    protected $required;

    /**
     * Construct an instance of a SpecFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->constraints = new ArrayMap();
        $this->defaults = new ArrayMap();
        $this->required = new ArrayList();
    }

    /**
     * @return static
     */
    public static function define()
    {
        return new static();
    }

    /**
     * Add a constraint that only works on the context.
     * These are complex constraints that usually work on more than one field
     * at a time.
     *
     * @param $constraint
     *
     * @return SpecFactory
     */
    public function letOnContext($constraint)
    {
        $this->defaultValue(static::FIELD_SELF, null);

        return $this->let(static::FIELD_SELF, $constraint);
    }

    /**
     * Set the default value of a field.
     *
     * @param string $field
     * @param mixed $value
     *
     * @throws InvalidArgumentException
     * @return $this
     */
    public function defaultValue($field, $value)
    {
        Arguments::define(Boa::string(), Boa::any())->check($field, $value);

        $this->defaults = $this->defaults->insert($field, $value);

        return $this;
    }

    /**
     * Add one or more constraints to a field.
     *
     * @param string $field
     * @param AbstractConstraint|AbstractConstraint[] $constraint
     *
     * @throws MismatchedArgumentTypesException
     * @return $this
     */
    public function let($field, $constraint)
    {
        Arguments::define(
            Boa::string(),
            Boa::either(
                Boa::instance(AbstractConstraint::class),
                Boa::arrOf(Boa::instance(AbstractConstraint::class))
            )
        )->check($field, $constraint);

        if (!$this->constraints->member($field)) {
            $this->constraints = $this->constraints->insert(
                $field,
                ArrayList::zero()
            );
        }

        if (!is_array($constraint)) {
            $constraint = [$constraint];
        }

        $this->constraints = $this->constraints->insert(
            $field,
            Maybe::fromMaybe(
                ArrayList::zero(),
                $this->constraints->lookup($field)
            )->append(ArrayList::of($constraint))
        );

        return $this;
    }

    /**
     * Add one or more fields to the list of fields that are required.
     *
     * @param string|string[] $fields
     *
     * @throws InvalidArgumentException
     * @return $this
     */
    public function required($fields)
    {
        Arguments::define(
            Boa::either(Boa::string(), Boa::arrOf(Boa::string()))
        )->check($fields);

        if (!is_array($fields)) {
            $fields = [$fields];
        }

        $this->required = $this->required->append(ArrayList::of($fields));

        return $this;
    }

    /**
     * Build an instance of the defined Spec.
     *
     * @return Spec
     */
    public function make()
    {
        return new Spec(
            $this->constraints->toArray(),
            $this->defaults->toArray(),
            $this->required->toArray()
        );
    }
}
