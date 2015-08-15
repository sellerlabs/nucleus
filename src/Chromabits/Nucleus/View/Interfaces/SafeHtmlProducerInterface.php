<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\View\Interfaces;

use Chromabits\Nucleus\View\SafeHtmlWrapper;

/**
 * Interface SafeHtmlProducerInterface.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\View\Interfaces
 */
interface SafeHtmlProducerInterface
{
    /**
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml();
}
