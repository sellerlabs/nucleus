<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\StaticObject;
use Chromabits\Nucleus\Meditation\Arguments;
use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Exceptions\InvalidArgumentException;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Chromabits\Nucleus\View\SafeHtmlWrapper;

/**
 * Class Html.
 *
 * Utilities for manipulating HTML.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class Html extends StaticObject
{
    /**
     * Escape the provided string.
     *
     * @param SafeHtmlWrapper|SafeHtmlProducerInterface|string $string
     *
     * @throws CoreException
     * @throws InvalidArgumentException
     * @return SafeHtmlWrapper|string
     */
    public static function escape($string)
    {
        Arguments::define(
            Boa::either(
                Boa::either(
                    Boa::instance(SafeHtmlWrapper::class),
                    Boa::instance(SafeHtmlProducerInterface::class)
                ),
                Boa::string()
            )
        )->check($string);

        if ($string instanceof SafeHtmlWrapper) {
            return $string;
        } elseif ($string instanceof SafeHtmlProducerInterface) {
            $result = $string->getSafeHtml();

            if ($result instanceof SafeHtmlWrapper) {
                return $result;
            } elseif ($result instanceof SafeHtmlProducerInterface) {
                return static::escape($result);
            }

            throw new CoreException(vsprintf(
                'Object of class %s implements SafeHtmlProducerInterface'
                . ' but it returned an unsafe type: %s',
                [get_class($string), TypeHound::fetch($result)]
            ));
        }

        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Mark a string as safe HTML.
     *
     * @param string|SafeHtmlWrapper $string
     *
     * @return SafeHtmlWrapper
     */
    public static function safe($string)
    {
        if ($string instanceof SafeHtmlWrapper) {
            return $string;
        }

        return new SafeHtmlWrapper($string);
    }
}
