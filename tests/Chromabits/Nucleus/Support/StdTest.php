<?php

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class StdTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class StdTest extends TestCase
{
    public function testApply()
    {
        $sum = function (...$nums) {
            return Std::reduce(function ($acc, $value) {
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
                )
            ]
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
            [28, Std::reduce($sum, 0, [1, 2, 3, 4, 5, 6, 7])],
            ['hello world', Std::reduce($concat, '', ['hello ', 'world'])],
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
            [28, Std::reduceRight($sum, 0, [1, 2, 3, 4, 5, 6, 7])],
            ['worldhello ', Std::reduceRight($concat, '', ['hello ', 'world'])],
        ]);
    }
}
