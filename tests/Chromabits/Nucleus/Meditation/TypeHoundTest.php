<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Primitives\CompoundTypes;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Primitives\SpecialTypes;
use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\Testing\Impersonator;
use Chromabits\Nucleus\Testing\TestCase;
use SplQueue;
use stdClass;

/**
 * Class TypeHoundTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class TypeHoundTest extends TestCase
{
    public function testResolve()
    {
        $resource = opendir('.');

        $this->assertEqualsMatrix([
            ['boolean', TypeHound::createAndResolve(true)],
            ['boolean', TypeHound::createAndResolve(false)],
            ['string', TypeHound::createAndResolve('omg')],
            ['string', TypeHound::createAndResolve('omg' . 9)],
            ['integer', TypeHound::createAndResolve(1)],
            ['integer', TypeHound::createAndResolve(0)],
            ['integer', TypeHound::createAndResolve(9 + 10)],
            ['integer', TypeHound::createAndResolve(9 - 10)],
            ['integer', TypeHound::createAndResolve(0)],
            ['float', TypeHound::createAndResolve(0.0)],
            ['float', TypeHound::createAndResolve(1.0)],
            ['float', TypeHound::createAndResolve(0.9 + 10)],
            ['array', TypeHound::createAndResolve([])],
            ['array', TypeHound::createAndResolve(['doge', 'gooby'])],
            ['array', TypeHound::createAndResolve(['omg', 9, new stdClass()])],
            ['object', TypeHound::createAndResolve(new stdClass())],
            ['object', TypeHound::createAndResolve(new SplQueue())],
            ['object', TypeHound::createAndResolve(new Impersonator())],
            ['object', TypeHound::createAndResolve(new Impersonator())],
            ['resource', TypeHound::createAndResolve($resource)],
        ]);

        closedir($resource);
    }

    public function testIsKnown()
    {
        $this->assertEqualsMatrix([
            [true, TypeHound::isKnown(ScalarTypes::SCALAR_BOOLEAN)],
            [true, TypeHound::isKnown(ScalarTypes::SCALAR_FLOAT)],
            [true, TypeHound::isKnown(ScalarTypes::SCALAR_INTEGER)],
            [true, TypeHound::isKnown(ScalarTypes::SCALAR_STRING)],
            [true, TypeHound::isKnown(CompoundTypes::COMPOUND_ARRAY)],
            [true, TypeHound::isKnown(CompoundTypes::COMPOUND_OBJECT)],
            [true, TypeHound::isKnown(SpecialTypes::SPECIAL_NULL)],
            [true, TypeHound::isKnown(SpecialTypes::SPECIAL_RESOURCE)],
        ]);
    }

    public function testMatches()
    {
        $this->assertTrue(
            (new TypeHound('some string'))->matches(new TypeHound('other'))
        );
        $this->assertTrue(
            (new TypeHound(34))->matches(new TypeHound(101))
        );
        $this->assertTrue(
            (new TypeHound([]))->matches(new TypeHound(['wow']))
        );

        $this->assertFalse(
            (new TypeHound('some string'))->matches(new TypeHound(0.78))
        );
        $this->assertFalse(
            (new TypeHound(0.45))->matches(new TypeHound(404))
        );
        $this->assertFalse(
            (new TypeHound([]))->matches(new TypeHound(0.78))
        );
    }
}
