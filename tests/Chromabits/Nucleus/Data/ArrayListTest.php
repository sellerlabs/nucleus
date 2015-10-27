<?php

namespace tests\Chromabits\Nucleus\Data;

use Chromabits\Nucleus\Data\ArrayList;
use Chromabits\Nucleus\Testing\TestCase;

class ArrayListTest extends TestCase
{
    public function testOf()
    {
        $list = ArrayList::of(['hello', 'world']);

        $this->assertInstanceOf(ArrayList::class, $list);
    }
}
