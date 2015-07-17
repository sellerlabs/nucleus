<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Testing;

/**
 * Class TestCase
 *
 * A base test case with some extra assertions
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * Asserts that a variable is of a given type.
     *
     * If $expected is an array, each string value will be used in a type
     * check. This is useful for checking if a class also implements certain
     * interfaces.
     *
     * @param string|array $expected
     * @param mixed $actual
     * @param string $message
     */
    public static function assertInstanceOf($expected, $actual, $message = '')
    {
        if (is_array($expected)) {
            foreach ($expected as $expectedSingle) {
                parent::assertInstanceOf($expectedSingle, $actual, $message);
            }

            return;
        }

        parent::assertInstanceOf($expected, $actual, $message);
    }
}
