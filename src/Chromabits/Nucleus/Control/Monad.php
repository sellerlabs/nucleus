<?php

namespace Chromabits\Nucleus\Control;

use Chromabits\Nucleus\Control\Interfaces\MonadInterface;
use Chromabits\Nucleus\Control\Traits\ChainTrait;
use Closure;

/**
 * Class Monad
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Monads
 */
abstract class Monad extends Applicative implements MonadInterface
{
    use ChainTrait;

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
     * Apply a function.
     *
     * @param callable|Closure $closure
     *
     * @return MonadInterface
     */
    public function fmap(callable $closure)
    {
        return $this->bind(function ($a) use ($closure) {
            return $this->of($closure($a));
        });
    }

    /**
     * Wrap value inside a monadic value.
     *
     * @param $value
     *
     * @return static
     */
    public static function of($value)
    {
        if ($value instanceof static) {
            return $value;
        }

        return new static($value);
    }
}
