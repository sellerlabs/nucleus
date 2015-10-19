<?php

namespace Chromabits\Nucleus\Control\Interfaces;

/**
 * Interface ApplicativeInterface
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Control\Interfaces
 */
interface ApplicativeInterface extends ApplyInterface
{
    /**
     * @param mixed $input
     *
     * @return ApplicativeInterface
     */
    public static function of($input);
}