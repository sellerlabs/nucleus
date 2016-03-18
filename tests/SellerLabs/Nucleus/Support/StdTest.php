<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\SellerLabs\Nucleus\Support;

use ArrayObject;
use SellerLabs\Nucleus\Data\ArrayList;
use SellerLabs\Nucleus\Meditation\Primitives\ScalarTypes;
use SellerLabs\Nucleus\Meditation\TypeHound;
use SellerLabs\Nucleus\Support\Std;
use SellerLabs\Nucleus\Testing\TestCase;
use Mockery;
use SplDoublyLinkedList;

/**
 * Class StdTest.
 *
 * @author Eduardo Trujillo <ed@sellerlabs.com>
 * @package Tests\SellerLabs\Nucleus\Support
 */
class StdTest extends TestCase
{
    public function testApply()
    {
        $sum = function (...$nums) {
            return Std::foldl(function ($acc, $value) {
                return $acc + $value;
            }, 0, $nums);
        };

        $this->assertEqualsMatrix([
            [28, Std::apply($sum, [1, 2, 3, 4, 5, 6, 7])],
            [
                'hello world',
                Std::apply(
                    Std::class . '::concat',
                    ['hello ', 'world']
                ),
            ],
        ]);
    }

    public function testCall()
    {
        $sum = function ($one, $two) {
            return $one + $two;
        };

        $this->assertEqualsMatrix([
            [11, Std::call($sum, 5, 6)],
            [[1, 2, 4, 5, 6], Std::call('array_merge', [1, 2], [4, 5], [6])],
        ]);
    }

    public function testConcat()
    {
        $this->assertEqualsMatrix([
            ['hello world', Std::concat('hello ', 'world')],
            [
                [1, 'one' => 'two', 2, 'six' => 'seven'],
                Std::concat([1, 'one' => 'two'], [2, 'six' => 'seven']),
            ],
        ]);
    }

    public function testTruthy()
    {
        $this->assertEqualsMatrix([
            [true, Std::truthy(true)],
            [false, Std::truthy()],
            [false, Std::truthy(false)],
            [false, Std::truthy(false, false)],
            [true, Std::truthy(false, true)],
            [true, Std::truthy(false, false, true)],
            [true, Std::truthy(false, false, true, false)],
        ]);
    }

    public function testNonempty()
    {
        $this->assertEqualsMatrix([
            ['hello', Std::nonempty(0, '', 'hello', [])],
            ['hello', Std::nonempty(0, '', [], 'hello')],
            [[1, 2, 3], Std::nonempty(0, '', [], '', [1, 2, 3])],
            [[1, 2, 3], Std::nonempty(0, '', false, '', [1, 2, 3])],
        ]);
    }

    public function testReduce()
    {
        $sum = function ($acc, $value) {
            return $acc + $value;
        };
        $concat = function ($acc, $value) {
            return $acc . $value;
        };

        $this->assertEqualsMatrix([
            [28, Std::foldl($sum, 0, [1, 2, 3, 4, 5, 6, 7])],
            ['hello world', Std::foldl($concat, '', ['hello ', 'world'])],
        ]);
    }

    public function testWithin()
    {
        $this->assertEqualsMatrix([
            [true, Std::within(0, 12, 3)],
            [true, Std::within(-40, 12, -5)],
            [true, Std::within(-100, -20, -40)],
            [false, Std::within(0.00, 12, 12.0001)],
            [false, Std::within(-40, 12, -80)],
            [false, Std::within(-100, -20, 40)],
        ]);
    }

    public function testReduceRight()
    {
        $sum = function ($acc, $value) {
            return $acc + $value;
        };
        $concat = function ($acc, $value) {
            return $acc . $value;
        };

        $this->assertEqualsMatrix([
            [28, Std::foldr($sum, 0, [1, 2, 3, 4, 5, 6, 7])],
            ['hello world---', Std::foldr($concat, '---', ['hello ', 'world'])],
        ]);
    }

    public function testMap()
    {
        $doubler = function ($item) {
            return $item * 2;
        };

        $list = new SplDoublyLinkedList();
        $list->push(1);
        $list->push(3);
        $list->push(4);
        $list->push(5);

        $this->assertEqualsMatrix([
            [[2, 6, 8, 10], Std::map($doubler, [1, 3, 4, 5])],
            [[2, 6, 8, 10], Std::map($doubler, $list)],
        ]);
    }

    public function testFilter()
    {
        $odd = function ($item) {
            return ($item % 2) != 0;
        };

        $list = new SplDoublyLinkedList();
        $list->push(1);
        $list->push(3);
        $list->push(4);
        $list->push(5);

        $this->assertEqualsMatrix([
            [[1, 3, 5], array_values(Std::filter($odd, [1, 3, 4, 5]))],
            [[1, 3, 5], array_values(Std::filter($odd, $list))],
        ]);
    }

    public function testCurry()
    {
        $rest = 0;

        $adder = function ($a, $b, $c, $d) {
            return $a + $b + $c + $d;
        };
        $variadicAdder = function (...$args) {
            return Std::foldl(function ($acc, $cur) {
                return $acc + $cur;
            }, 0, $args);
        };
        $partiallyVariadicAdder = function ($a, $b, $c, ...$args) use (&$rest) {
            $rest = Std::foldl(function ($acc, $cur) {
                return $acc + $cur;
            }, 0, $args);

            return $a + $b + $c;
        };

        $one = Std::curry($adder, 2, 5);
        $two = $one(6);

        // Here we test adding one additional parameter that was not expected.
        // This should allow us to support partially variadic functions.
        $three = $two(10, 1000);

        $this->assertEquals(23, $three);

        // Variadic functions will return immediately since we can't determine
        // when they have been fulfilled.
        $four = Std::curry($variadicAdder, 2, 5);

        $this->assertEquals(
            ScalarTypes::SCALAR_INTEGER,
            TypeHound::fetch($four)
        );
        $this->assertEquals(7, $four);

        $seven = Std::curry($partiallyVariadicAdder, 8, 5);
        $eight = $seven(9, 102, 20);

        $this->assertEquals(
            ScalarTypes::SCALAR_INTEGER,
            TypeHound::fetch($eight)
        );
        $this->assertEquals(22, $eight);
        $this->assertEquals(122, $rest);
    }

    public function testCallSetters()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $mock = Mockery::mock();

        $mock->shouldReceive('setFirstName');
        $mock->shouldReceive('setLastName');

        Std::callSetters($mock, $input);

        $mock->shouldHaveReceived('setFirstName', ['content']);
        $mock->shouldHaveReceived('setLastName', [null]);
    }

    public function testCallSettersWithAllowed()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $mock = Mockery::mock();

        $mock->shouldReceive('setFirstName');
        $mock->shouldReceive('setLastName');

        Std::callSetters($mock, $input, ['first_name']);

        $mock->shouldHaveReceived('setFirstName', ['content']);
        $mock->shouldNotHaveReceived('setLastName');
    }

    public function testFoldl()
    {
        $input = ArrayList::of([1, 2, 3, 4, 5]);
        $inputChars = ArrayList::of(['h', 'e', 'l', 'l', 'o']);
        $sum = function ($x, $y) {
            return $x + $y;
        };
        $concat = function ($x, $y) {
            return $x . $y;
        };

        $this->assertEquals(
            10 + 1 + 2 + 3 + 4 + 5,
            Std::foldl($sum, 10, $input)
        );
        $this->assertEquals(
            '---hello',
            Std::foldl($concat, '---', $inputChars)
        );
    }

    public function testFoldr()
    {
        $input = ArrayList::of([1, 2, 3, 4, 5]);
        $inputChars = ArrayList::of(['h', 'e', 'l', 'l', 'o']);
        $sum = function ($x, $y) {
            return $x + $y;
        };
        $concat = function ($x, $y) {
            return $x . $y;
        };

        $this->assertEquals(
            10 + 5 + 4 + 3 + 2 + 1,
            Std::foldr($sum, 10, $input)
        );
        $this->assertEquals(
            'hello---',
            Std::foldr($concat, '---', $inputChars)
        );
    }

    public function testEach()
    {
        $result = '';
        $concat = function ($x) use (&$result) {
            $result .= $x;
        };

        Std::each($concat, ['h', 'e', 'l', 'l', 'o', ' ']);
        Std::each($concat, ArrayList::of(['w', 'o', 'r', 'l', 'd']));
        Std::each($concat, new ArrayObject([' ', ':', ')']));

        $this->assertEquals('hello world :)', $result);
    }
}
