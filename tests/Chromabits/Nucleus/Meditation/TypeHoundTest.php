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
            ['boolean', TypeHound::fetch(true)],
            ['boolean', TypeHound::fetch(false)],
            ['string', TypeHound::fetch('omg')],
            ['string', TypeHound::fetch('omg' . 9)],
            ['integer', TypeHound::fetch(1)],
            ['integer', TypeHound::fetch(0)],
            ['integer', TypeHound::fetch(9 + 10)],
            ['integer', TypeHound::fetch(9 - 10)],
            ['integer', TypeHound::fetch(0)],
            ['float', TypeHound::fetch(0.0)],
            ['float', TypeHound::fetch(1.0)],
            ['float', TypeHound::fetch(0.9 + 10)],
            ['array', TypeHound::fetch([])],
            ['array', TypeHound::fetch(['doge', 'gooby'])],
            ['array', TypeHound::fetch(['omg', 9, new stdClass()])],
            ['object', TypeHound::fetch(new stdClass())],
            ['object', TypeHound::fetch(new SplQueue())],
            ['object', TypeHound::fetch(new Impersonator())],
            ['object', TypeHound::fetch(new Impersonator())],
            ['resource', TypeHound::fetch($resource)],
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
