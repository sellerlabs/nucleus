<?php

namespace Tests\SellerLabs\Nucleus\Data;

use SellerLabs\Nucleus\Data\ArrayList;
use SellerLabs\Nucleus\Testing\TestCase;

/**
 * Class ArrayListTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Data
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
