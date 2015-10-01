<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Constraints\AbstractConstraint;
use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Support\Std;

/**
 * Class SpecFactory
 *
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
     * @var AbstractConstraint[]
     */
    protected $constraints;

    /**
     * @var array
     */
    protected $defaults;

    /**
     * @var string[]
     */
    protected $required;

    /**
     * Construct an instance of a SpecFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->constraints = [];
        $this->defaults = [];
        $this->required = [];
    }

    /**
     * @return static
     */
    public static function define()
    {
        return new static();
    }

    /**
     * Add one or more constraints to a field.
     *
     * @param string $field
     * @param AbstractConstraint|AbstractConstraint[] $constraint
     *
     * @return $this
     * @throws Exceptions\MismatchedArgumentTypesException
     */
    public function let($field, $constraint)
    {
        Arguments::contain(
            Boa::string(),
            Boa::either(
                Boa::instance(AbstractConstraint::class),
                Boa::arrOf(Boa::instance(AbstractConstraint::class))
            )
        )->contain($field, $constraint);

        if (!Arr::has($this->constraints, $field)) {
            $this->constraints[$field] = [];
        }

        if (!is_array($constraint)) {
            $constraint = [$constraint];
        }

        $this->constraints[$field] = Std::concat(
            $this->constraints[$field],
            $constraint
        );

        return $this;
    }

    /**
     * Add a constraint that only works on the context.
     *
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
     * @return $this
     * @throws Exceptions\InvalidArgumentException
     */
    public function defaultValue($field, $value)
    {
        Arguments::contain(Boa::string(), Boa::any())->check($field, $value);

        $this->defaults[$field] = $value;

        return $this;
    }

    /**
     * Add one or more fields to the list of fields that are required.
     *
     * @param string|string[] $fields
     *
     * @return $this
     * @throws Exceptions\InvalidArgumentException
     */
    public function required($fields) {
        Arguments::contain(
            Boa::either(Boa::string(), Boa::arrOf(Boa::string()))
        )->check($fields);

        if (!is_array($fields)) {
            $fields = [$fields];
        }

        $this->required = array_merge($this->required, $fields);

        return $this;
    }

    /**
     * Build an instance of the defined Spec.
     *
     * @return Spec
     */
    public function make()
    {
        return new Spec($this->constraints, $this->defaults, $this->required);
    }
}