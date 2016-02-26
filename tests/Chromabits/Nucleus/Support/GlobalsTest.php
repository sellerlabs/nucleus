<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class GlobalsTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class GlobalsTest extends TestCase
{
    public function testWithin()
    {
        $this->assertTrue(Std::within(0, 4500, 30));
        $this->assertTrue(Std::within(-300, 4500.5, 0));
        $this->assertTrue(Std::within(-300, -1, -20));

        $this->assertFalse(Std::within(0, 4500, -30));
        $this->assertFalse(Std::within(-300, 4500, -7000));
        $this->assertFalse(Std::within(-300, -1, 20));
    }

    public function testWithinValidation()
    {
        $this->setExpectedException(LackOfCoffeeException::class);

        Std::within(4000, -1, 34);
    }

    public function testCoalesce()
    {
        $this->assertEquals('doge', Std::coalesce('doge'));
        $this->assertEquals('doge', Std::coalesce(null, 'doge'));
        $this->assertEquals('doge', Std::coalesce(null, null, 'doge'));
        $this->assertEquals('doge', Std::coalesce(null, null, 'doge', 'dolan'));
        $this->assertEquals('gopher', Std::coalesce('gopher', null, 'doge'));
        $this->assertNull(Std::coalesce());
    }

    public function testMbCtypeLower()
    {
        $this->assertTrue(mb_ctype_lower('こんにちは世界'));
        $this->assertTrue(mb_ctype_lower('こんにちは世界-abcabcabc'));
        $this->assertFalse(mb_ctype_lower('こんにちは世界-abcabcABC'));
        $this->assertTrue(mb_ctype_lower(
            'hello wørld ∫∫ßß∆˙©ƒßå¬'
        ));
        $this->assertFalse(mb_ctype_lower(
            'hellÔ wørld ∫∫ßß∆˙©ƒßå¬'
        ));
    }
}
