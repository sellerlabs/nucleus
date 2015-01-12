<?php

namespace spec\Chromabits\Nucleus\Support;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ArrayUtilsSpec extends ObjectBehavior
{
    function let($nameable)
    {
        $nameable->beADoubleOf('Chromabits\Nucleus\Testing\Interfaces\NameableInterface');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Chromabits\Nucleus\Support\ArrayUtils');
    }

    function it_filters_null_values_from_arrays()
    {
        $input = [
            'key1' => 'content',
            'key2' => null,
            'otherkey' => null
        ];

        $output = [
            'key1' => 'content'
        ];

        $this->filterNullValues($input)->shouldReturn($output);
    }

    function it_filters_null_and_allowed_values_from_array()
    {
        $input = [
            'key1' => 'content',
            'key2' => null,
            'otherkey' => null,
            'otherkey2' => 'ishouldnotbehere'
        ];

        $output = [
            'key1' => 'content'
        ];

        $this->filterNullValues($input, ['key1'])->shouldReturn($output);
    }

    function it_should_call_setters($nameable)
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $this->callSetters($nameable, $input);

        $nameable->setFirstName('content')->shouldHaveBeenCalled();
        $nameable->setLastName(null)->shouldHaveBeenCalled();
    }

    function it_should_only_call_allowed_setters($nameable)
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $this->callSetters($nameable, $input, ['first_name']);

        $nameable->setFirstName('content')->shouldHaveBeenCalled();
        $nameable->setLastName(null)->shouldNotHaveBeenCalled();
    }

    function it_reduces_arrays_to_allowed_keys()
    {
        $input = [
            'first_name' => 'content',
            'last_name' => null,
        ];

        $output = [
            'first_name' => 'content'
        ];

        $this->filterKeys($input, ['first_name'])->shouldReturn($output);
        $this->filterKeys($input, [])->shouldReturn($input);
        $this->filterKeys($input, null)->shouldReturn($input);
        $this->filterKeys($input)->shouldReturn($input);
    }
}
