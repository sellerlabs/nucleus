<?php

namespace Tests\Chromabits\Nucleus\Foundation;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\Entity;
use Chromabits\Nucleus\Testing\TestCase;
use Mockery;

/**
 * Class EntityTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Foundation
 */
class EntityTest extends TestCase
{
    public function testFill()
    {
        $instance = new SampleEntity();

        $instance->setFirstName('Bobby');

        $instance->fill([
            'last_name' => 'tables',
            'age' => '34',
            'pin' => 1337
        ]);

        $this->assertEquals([
            'first_name' => 'Bobby',
            'last_name' => 'Tables',
            'age' => 34,
        ], $instance->toArray());
    }

    public function testFillWithUndeclared()
    {
        $this->setExpectedException(LackOfCoffeeException::class);

        $instance = Mockery::mock(Entity::class);

        $instance->shouldDeferMissing();

        $instance->fill([]);
    }
}