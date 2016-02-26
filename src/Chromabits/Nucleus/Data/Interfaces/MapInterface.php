<?php

namespace Chromabits\Nucleus\Data\Interfaces;

/**
 * Interface MapInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Data\Interfaces
 */
interface MapInterface extends ReadMapInterface, IterableInterface
{
    //
    /**
     * Return a new Map of the same type containing the added key.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function insert($key, $value);

    /**
     * Return a new Map of the same type without the specified key.
     *
     * @param string $key
     *
     * @return static
     */
    public function delete($key);
}
