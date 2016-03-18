<?php

namespace SellerLabs\Nucleus\Control\Interfaces;

/**
 * Interface ApplicativeInterface
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Control\Interfaces
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