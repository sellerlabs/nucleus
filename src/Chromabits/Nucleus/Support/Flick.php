<?php

namespace Chromabits\Nucleus\Support;

use ArrayAccess;
use Chromabits\Nucleus\Exceptions\UnknownKeyException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Support\Abstractors\ReadMap;
use Traversable;

/**
 * Class Flick
 *
 * A more functional switch block.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Flick extends BaseObject
{
    /**
     * @var array|Traversable
     */
    protected $functions;

    /**
     * @var string
     */
    protected $default;

    /**
     * Construct an instance of a Flick.
     *
     * @param array|ArrayAccess|Traversable $functions
     * @param string $default
     *
     * @throws InvalidArgumentException
     * @throws \Chromabits\Nucleus\Exceptions\LackOfCoffeeException
     */
    public function __construct($functions, $default = 'default')
    {
        parent::__construct();

        Arguments::contain(
            Boa::lst(),
            Boa::either(Boa::string(), Boa::integer())
        )->check($functions, $default);

        $this->functions = $functions;
        $this->default = $default;
    }

    /**
     * Construct an instance of a Flick.
     *
     * @param array|ArrayAccess|Traversable $functions
     * @param string|integer $default
     *
     * @return Flick
     */
    public static function when($functions, $default = 'default')
    {
        return new Flick($functions, $default);
    }

    /**
     * Run the flick on input.
     *
     * @param string|integer $input
     *
     * @return mixed
     * @throws UnknownKeyException
     */
    public function go($input)
    {
        Arguments::contain(Boa::readMap())->contain($input);

        $map = new ReadMap($this->functions);

        if ($map->has($input)) {
            /** @var callable $function */
            $function = $map->get($input);

            return $function();
        } elseif ($map->has($this->default)) {
            /** @var callable $function */
            $function = $map->get($this->default);

            return $function();
        }

        throw new UnknownKeyException();
    }
}
