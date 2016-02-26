<?php

namespace Tests\Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ArrayListTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Data
 */
class ArrayListTest extends TestCase
{
    public function testConstructor()
    {
        new ArrayList();
        new ArrayList([]);
        new ArrayList(['hello', 'world']);
    }

    public function testZero()
    {
        $instance = ArrayList::zero();

        $this->assertEquals([], $instance->toArray());
    }

    public function testAppend()
    {
        $instance = ArrayList::of(['hello']);

        $final = $instance->append(ArrayList::of(['world']));

        $this->assertNotEquals($instance, $final);
        $this->assertEquals(['hello', 'world'], $final->toArray());
    }

    public function testOf()
    {
        $list = ArrayList::of(['hello', 'world']);

        $this->assertInstanceOf(ArrayList::class, $list);
    }
}
