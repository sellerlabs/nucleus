<?php

namespace benchmarks\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\Std;

/**
 * Class StdBench.
 *
 * @Revs(1000)
 * @Iterations(20)
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package benchmarks\Chromabits\Nucleus\Support
 */
class StdBench
{
    /**
     * @var array<string, string>
     */
    protected $keyValueArray;

    /**
     * Construct an instance of a StdBench.
     */
    public function __construct()
    {
        $this->keyValueArray = [
            'hello' => 'world',
            'omg' => 'icant',
            'wtf' => 'solong',
            'benchmarks' => 'gonnabench',
        ];
    }

    public function benchMap()
    {
        Std::map(function ($value, $key) {
            return $value . ' ' . $key;
        }, $this->keyValueArray);
    }

    public function benchPhpArrayMapWithKeys()
    {
        array_map(function ($value, $key) {
            return $value . ' ' . $key;
        }, $this->keyValueArray, array_keys($this->keyValueArray));
    }

    public function benchPhpArrayMapWithoutKeys()
    {
        array_map(function ($value) {
            return $value . ' ';
        }, $this->keyValueArray);
    }
}