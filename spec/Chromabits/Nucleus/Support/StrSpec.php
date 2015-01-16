<?php

namespace spec\Chromabits\Nucleus\Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StrSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Chromabits\Nucleus\Support\Str');
    }

    function it_converts_snake_case_to_camel_case()
    {
        $this->camel('snake_case_stuff')->shouldReturn('snakeCaseStuff');
    }

    function it_converts_studly_case_to_camel_case()
    {
        $this->camel('StudlyCaseStuff')->shouldReturn('studlyCaseStuff');
    }

    function it_converts_snake_case_to_studly_case()
    {
        $this->studly('snake_case_stuff')->shouldReturn('SnakeCaseStuff');
    }

    function it_converts_camel_case_to_studly_case()
    {
        $this->studly('camelCaseStuff')->shouldReturn('CamelCaseStuff');
    }

    function it_converts_studly_case_to_snake_case()
    {
        $this->snake('StudlyCaseStuff')->shouldReturn('studly_case_stuff');
    }

    function it_converts_camel_case_to_snake_case()
    {
        $this->snake('camelCaseStuff')->shouldReturn('camel_case_stuff');
    }

    function it_should_use_the_camel_case_cache()
    {
        $this->setCamelCache([
            'this_is_cached' => 'This is cached'
        ]);

        $this->camel('this_is_cached')->shouldReturn('This is cached');
    }

    function it_should_use_the_studly_case_cache()
    {
        $this->setStudlyCache([
            'this_is_cached' => 'This is cached'
        ]);

        $this->studly('this_is_cached')->shouldReturn('This is cached');
    }

    function it_should_use_the_snake_case_cache()
    {
        $this->setSnakeCache([
            'this_is_cached_' => 'This is cached'
        ]);

        $this->snake('this_is_cached')->shouldReturn('This is cached');
    }

    function it_should_generate_random_strings()
    {
        $this->random()->shouldBeString();

        $this->random()->shouldHaveLength(16);

        $this->random(32)->shouldHaveLength(32);

        $otherRandom = $this->random();

        $this->random()->shouldNotEqual($otherRandom);
    }

    function it_should_generate_quick_random_strings()
    {
        $this->quickRandom()->shouldBeString();

        $this->quickRandom()->shouldHaveLength(16);

        $this->quickRandom(32)->shouldHaveLength(32);

        $otherRandom = $this->quickRandom();

        $this->quickRandom()->shouldNotEqual($otherRandom);
    }

    public function getMatchers()
    {
        return [
            'haveLength' => function($subject, $key) {
                return strlen($subject) == $key;
            },
        ];
    }
}
