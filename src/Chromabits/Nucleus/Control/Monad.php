<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Control\Interfaces\MonadInterface;

/**
 * Class Monad
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads
 */
abstract class Monad extends BaseObject implements MonadInterface
{
    /**
     * The wrapped value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Construct an instance of a Monad.
     *
     * @param $value
     */
    public function __construct($value)
    {
        parent::__construct();

        $this->value = $value;
    }

    /**
     * Wrap value inside a monadic value.
     *
     * @param $value
     *
     * @return static
     */
    public static function unit($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        return new static($value);
    }
}