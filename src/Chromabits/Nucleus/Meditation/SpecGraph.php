<?php

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Arr;

/**
 * Class SpecGraph
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecGraph extends BaseObject
{
    protected $nodes;

    protected $incomingEdges;

    protected $pending;

    protected $checked;

    protected $results;

    protected $failed;

    public function __construct()
    {
        $this->nodes = [];
        $this->incomingEdges = [];
        $this->pending = [];
        $this->checked = [];
        $this->results = [];
        $this->failed = false;
    }

    public function add($name, array $dependencies, Spec $node)
    {
        $this->nodes[$name] = $node;
        $this->incomingEdges[$name] = $dependencies;

        if (count($dependencies) === 0) {
            $this->pending[] = $name;
        }
    }

    protected function iterate(array $input)
    {
        foreach ($this->pending as $name) {
            $result = $this->nodes[$name]->check($input);

            if ($result->failed()) {
                $this->failed = true;
            }

            $this->checked[$name] = $result;
        }

        $this->pending = [];

        foreach (Arr::keys($this->nodes) as $name) {
            if (array_key_exists($name, $this->checked)) {
                continue;
            }

            $free = true;
            foreach ($this->incomingEdges[$name] as $requirement) {
                if (!array_key_exists($requirement, $this->checked)) {
                    $free = false;
                    break;
                }
            }

            if ($free) {
                $this->pending[] = $name;
            }
        }
    }

    public function check(array $input)
    {
        // Automatic reset
        if (count($this->pending) === 0) {
            foreach (Arr::keys($this->nodes) as $name) {
                if (count($this->incomingEdges[$name]) === 0) {
                    $this->pending[] = $name;
                }
            }

            $this->checked = [];
            $this->results = [];
            $this->failed = false;
        }

        // Actual process
        while (count($this->checked) < count($this->nodes)) {
            if (count($this->pending) === 0) {
                throw new CoreException('Unable to resolve constraint graph.');
            }

            $this->iterate($input);

            if ($this->failed) {
                $this->pending = [];
                break;
            }
        }

        // Aggregate results
        $missing = [];
        $failed = [];

        array_map(function (SpecResult $result) use (&$missing, &$failed) {
            $missing[] = $result->getMissing();
            $failed[] = $result->getFailed();
        }, $this->checked);

        return new SpecResult(
            Arr::mergev($missing),
            Arr::mergev($failed),
            $this->failed ? SpecResult::STATUS_FAIL : SpecResult::STATUS_PASS
        );
    }
}
