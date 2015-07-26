<?php

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\TypeHound;
use Chromabits\Nucleus\Testing\Impersonator;
use Chromabits\Nucleus\Testing\TestCase;
use SplQueue;
use stdClass;

/**
 * Class ReflectorTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class ReflectorTest extends TestCase
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
}
