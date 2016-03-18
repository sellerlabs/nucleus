<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace SellerLabs\Nucleus\Meditation\Interfaces;

/**
 * Interface CheckResultInterface.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package SellerLabs\Nucleus\Meditation\Interfaces
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
