<?php

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\Arr;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class ArrTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class ArrTest extends TestCase
{
    public function testWalk()
    {
        $input = [
            'test' => 'omg',
            'yes' => [
                'works?' => ['perhaps'],
                'one' => 'day'
            ]
        ];

        Arr::walk($input, function ($key, $value, &$array, $path) {
            $array[$key] = 'huh';
        }, true, '', true);

        $output = [
            'test' => 'huh',
            'yes' => [
                'works?' => ['huh'],
                'one' => 'huh'
            ]
        ];

        $this->assertEquals($output, $input);
    }

    public function testWalkWithIngnoreLeaves()
    {
        $input = [
            'test' => 'omg',
            'yes' => [
                'works?' => ['perhaps'],
                'one' => 'day'
            ]
        ];

        Arr::walk($input, function ($key, $value, &$array, $path) {
            $array[$key] = 'huh';
        }, true, '', false);

        $output = [
            'test' => 'huh',
            'yes' => [
                'works?' => 'huh',
                'one' => 'huh'
            ]
        ];

        $this->assertEquals($output, $input);
    }
}
