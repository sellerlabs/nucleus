<?php

namespace Chromabits\Nucleus\Meditation\Interfaces;

/**
 * Interface CheckResultInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation\Interfaces
 */
interface CheckResultInterface
{
    /**
     * Get missing fields.
     *
     * @return string[]
     */
    public function getMissing();

    /**
     * Get failed constrains for every field.
     *
     * @return array[]
     */
    public function getFailed();

    /**
     * Return true if the check passed.
     *
     * @return bool
     */
    public function passed();

    /**
     * Return false if the check failed.
     *
     * @return bool
     */
    public function failed();
}