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

use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Meditation\SpecGraph;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class SpecGraphTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class SpecGraphTest extends TestCase
{
    public function testSimpleSpec()
    {
        $graph = new SpecGraph();

        $graph->add('input', [], Spec::define([
            'sleepy' => Boa::boolean(),
            'tennis_balls' => Boa::integer(),
            'message' => Boa::either(Boa::string(), Boa::integer()),
        ], [], ['message']));

        $result = $graph->check([
            'sleepy' => true,
            'tennis_balls' => 3,
            'message' => 'hello',
        ]);

        $this->assertTrue($result->passed());

        $result2 = $graph->check([
            'sleepy' => 45,
            'tennis_balls' => false,
        ]);

        $this->assertEqualsMatrix([
            [true, $result2->failed()],
            [2, count($result2->getFailed())],
            [['message'], $result2->getMissing()],
        ]);
    }

    public function testComplexSpec()
    {
        $graph = new SpecGraph();

        $graph->add('input', [], Spec::define([
            'sleepy' => Boa::boolean(),
            'tennis_balls' => Boa::integer(),
            'message' => Boa::either(Boa::string(), Boa::integer()),
        ], [], ['message']));

        $graph->add('allowedMessage', ['input'], Spec::define([
            'message' => [
                Boa::in(['hi', 'how are you?', 'you dumb']),
                Boa::in(['hi', 'how are you?', 'you are smart']),
            ],
        ], [], ['message']));

        $graph->add('validBallCount', ['input'], Spec::define([
            'tennis_balls' => Boa::between(1, 10),
        ]));

        $graph->add('additionalBallProps', ['validBallCount'], Spec::define([
            'ball_color' => [
                Boa::string(),
                Boa::in(['blue', 'red', 'yellow']),
            ],
        ], [], ['ball_color']));

        $result = $graph->check([
            'sleepy' => true,
            'tennis_balls' => 3,
            'message' => 'hi',
            'ball_color' => 'blue',
        ]);

        $this->assertTrue($result->passed());

        $result2 = $graph->check([
            'sleepy' => 1,
            'tennis_balls' => 3,
        ]);

        $this->assertEqualsMatrix([
            [true, $result2->failed()],
            [1, count($result2->getFailed())],
            [['message'], $result2->getMissing()],
        ]);

        $result3 = $graph->check([
            'sleepy' => true,
            'tennis_balls' => -30,
            'message' => 'hello',
        ]);

        $this->assertEqualsMatrix([
            [true, $result3->failed()],
            [2, count($result3->getFailed())],
            [[], $result3->getMissing()],
        ]);

        $result4 = $graph->check([
            'sleepy' => true,
            'tennis_balls' => 3,
            'message' => 'how are you?',
        ]);

        $this->assertEqualsMatrix([
            [true, $result4->failed()],
            [0, count($result4->getFailed())],
            [['ball_color'], $result4->getMissing()],
        ]);

        $result5 = $graph->check([
            'sleepy' => true,
            'tennis_balls' => 3,
            'message' => 'how are you?',
            'ball_color' => 'liquid_gold',
        ]);

        $this->assertEqualsMatrix([
            [true, $result5->failed()],
            [1, count($result5->getFailed())],
            [[], $result5->getMissing()],
        ]);
    }
}
