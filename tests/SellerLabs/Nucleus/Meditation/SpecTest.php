<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Meditation;

use SellerLabs\Nucleus\Exceptions\CoreException;
use SellerLabs\Nucleus\Exceptions\LackOfCoffeeException;
use SellerLabs\Nucleus\Meditation\Boa;
use SellerLabs\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use SellerLabs\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Meditation\Spec;
use SellerLabs\Nucleus\Testing\TestCase;
use SellerLabs\Nucleus\Validation\Constraints\StringLengthConstraint;
use stdClass;

/**
 * Class SpecTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Meditation
 */
class SpecTest extends TestCase
{
    /**
     * @throws LackOfCoffeeException
     */
    public function testCheck()
    {
        $instance = new Spec([
            'name' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'count' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER),
            'exception' => new ClassTypeConstraint(CoreException::class),
        ]);

        $this->assertEqualsMatrix([
            [true, $instance->check([
                'name' => 'Git',
                'count' => 101,
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 0,
                'count' => 101,
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 'Git',
                'count' => [],
                'exception' => new CoreException('Missing git repository.'),
            ])->passed()],
            [false, $instance->check([
                'name' => 'Git',
                'count' => 101,
                'exception' => new stdClass(),
            ])->passed()],
            [false, $instance->check([
                'name' => 0,
                'count' => 101,
                'exception' => new stdClass(),
            ])->passed()],
        ]);
    }

    public function testCheckNested()
    {
        $instance = Spec::define([
            'name' => Boa::string(),
            'count' => Boa::integer(),
            'address' => Spec::define([
                'street' => Spec::define([
                    'first_line' => Boa::string(),
                    'second_line' => Boa::either(Boa::string(), Boa::integer()),
                ], [], ['first_line']),
                'state' => [
                    Boa::string(),
                    new StringLengthConstraint(2, 2),
                ],
                'zip' => Boa::integer(),
            ], [], ['street', 'zip']),
        ]);

        $resultOne = $instance->check([
            'name' => 'Doge',
            'count' => 7,
            'address' => [],
        ]);

        $this->assertTrue($resultOne->failed());

        $resultTwo = $instance->check([
            'name' => 'Doge',
            'count' => 7,
            'address' => [
                'street' => [],
                'state' => 90,
            ],
        ]);

        $failed = $resultTwo->getFailed();
        $missing = $resultTwo->getMissing();

        $this->assertTrue($resultTwo->failed());
        $this->assertArrayHasKey('address.state', $failed);
        $this->assertTrue(in_array('address.street.first_line', $missing));

        $resultThree = $instance->check([
            'name' => 'Doge',
            'count' => 7,
            'address' => [
                'street' => [
                    'first_line' => '1337 Hacker Way',
                ],
                'state' => 'GA',
                'zip' => 13370,
            ],
        ]);

        $this->assertTrue($resultThree->passed());
    }

    public function testCheckWithInvalidConstraint()
    {
        $this->setExpectedException(
            CoreException::class,
            'Unexpected constraint type: array.'
        );

        $spec = new Spec([
            'somefield' => [['invalid'], 'wow', 1337],
        ]);

        $spec->check(['somefield' => 'wowo']);
    }

    public function testAccessors()
    {
        $strings = Boa::string();

        $spec = new Spec([
            'name' => $strings,
        ], [
            'name' => 'Bobby',
        ], ['name']);

        $this->assertEqualsMatrix([
            [['name' => $strings], $spec->getConstraints()],
            [['name' => 'Bobby'], $spec->getDefaults()],
            [['name'], $spec->getRequired()],
        ]);
    }
}
