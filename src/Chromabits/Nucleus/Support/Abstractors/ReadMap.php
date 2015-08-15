<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Support\Abstractors;

use ArrayAccess;
use Chromabits\Nucleus\Exceptions\UnknownKeyException;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Traversable;

/**
 * Class ReadMap.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support\Abstractors
 */
class ReadMap extends AbstractAbstractor
{
    /**
     * @var array|ArrayAccess|Traversable
     */
    protected $readMap;

    /**
     * @var bool
     */
    protected $isArrayAccess;

    /**
     * @var bool
     */
    protected $isArray;

    /**
     * Construct an instance of a ReadMap.
     *
     * @param array|ArrayAccess|Traversable $readMap
     */
    public function __construct($readMap)
    {
        parent::__construct();

        $this->readMap = $readMap;

        $this->isArray = is_array($readMap);
        $this->isArrayAccess = ($readMap instanceof ArrayAccess);
    }

    /**
     * Get value of a key.
     *
     * @param string|int $key
     *
     * @throws UnknownKeyException
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function get($key)
    {
        Arguments::contain(Boa::either(Boa::string(), Boa::integer()))
            ->check($key);

        if ($this->isArray) {
            return $this->readMap[$key];
        } elseif ($this->isArrayAccess) {
            return $this->readMap->offsetGet($key);
        }

        foreach ($this->readMap as $currentKey => $value) {
            if ($currentKey === $key) {
                return $value;
            }
        }

        throw new UnknownKeyException();
    }

    /**
     * Return whether or not a key exists on this map.
     *
     * @param string|int $key
     *
     * @throws InvalidArgumentException
     * @return bool
     */
    public function has($key)
    {
        Arguments::contain(Boa::either(Boa::string(), Boa::integer()))
            ->check($key);

        if ($this->isArray) {
            return array_key_exists($key, $this->readMap);
        } elseif ($this->isArrayAccess) {
            return $this->readMap->offsetExists($key);
        }

        foreach ($this->readMap as $currentKey => $value) {
            if ($currentKey === $key) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get a list of names of the types this abstractor can work on.
     *
     * @return array
     */
    public function getAbstractedTypes()
    {
        return [
            CompoundTypes::COMPOUND_ARRAY,
            ArrayAccess::class,
            Traversable::class,
        ];
    }
}
