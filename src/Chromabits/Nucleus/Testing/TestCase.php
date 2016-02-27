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

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use PHPUnit_Framework_TestCase as BaseTestCase;

/**
 * Class TestCase.
 *
 * A base test case with some extra assertions
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing
 */
abstract class TestCase extends BaseTestCase
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

    /**
     * Run assert equals with an input matrix.
     *
     * Every entry should be formatted as following:
     *
     * [$expected, $equals, $message (optional)]
     *
     * @param array $comparisons
     *
     * @throws LackOfCoffeeException
     */
    public static function assertEqualsMatrix(array $comparisons)
    {
        $total = count($comparisons);

        foreach ($comparisons as $index => $comparison) {
            if (count($comparison) < 2) {
                throw new LackOfCoffeeException('Comparison entry is invalid.');
            }

            if (array_key_exists(2, $comparison)) {
                $message = $comparison[2];
            } else {
                $message = vsprintf(
                    'Comparison %d (of %d) is expected to be equal.',
                    [$index + 1, $total]
                );
            }

            static::assertEquals(
                $comparison[0],
                $comparison[1],
                $message
            );
        }
    }

    /**
     * Assert that the provided value is an array.
     *
     * @param mixed $actual
     * @param string $message
     */
    public static function assertIsArray($actual, $message = '')
    {
        static::assertInternalType(
            CompoundTypes::COMPOUND_ARRAY,
            $actual,
            $message
        );
    }

    /**
     * Assert that an object has all attributes in an array.
     *
     * @param array $attributes
     * @param mixed $object
     * @param string $message
     */
    public function assertObjectHasAttributes(
        array $attributes,
        $object,
        $message = ''
    ) {
        foreach ($attributes as $attr) {
            $this->assertObjectHasAttribute($attr, $object, $message);
        }
    }
}
