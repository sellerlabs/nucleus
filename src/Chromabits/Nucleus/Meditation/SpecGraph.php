<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Meditation\Interfaces\CheckableInterface;
use Chromabits\Nucleus\Support\Arr;

/**
 * Class SpecGraph.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecGraph extends BaseObject implements CheckableInterface
{
    /**
     * @var Spec[]
     */
    protected $nodes;

    /**
     * @var array
     */
    protected $incomingEdges;

    /**
     * @var array
     */
    protected $pending;

    /**
     * @var array
     */
    protected $checked;

    /**
     * @var SpecResult[]
     */
    protected $results;

    /**
     * @var bool
     */
    protected $failed;

    /**
     * Construct an instance of a SpecGraph.
     */
    public function __construct()
    {
        parent::__construct();

        $this->nodes = [];
        $this->incomingEdges = [];
        $this->pending = [];
        $this->checked = [];
        $this->results = [];
        $this->failed = false;
    }

    /**
     * Define and create a new spec graph.
     *
     * @return SpecGraphFactory
     */
    public static function create()
    {
        return new SpecGraphFactory();
    }

    /**
     * Add a node to the graph.
     *
     * @param string $name
     * @param string[] $dependencies
     * @param Spec $node
     */
    public function add($name, array $dependencies, Spec $node)
    {
        $this->nodes[$name] = $node;
        $this->incomingEdges[$name] = $dependencies;

        if (count($dependencies) === 0) {
            $this->pending[] = $name;
        }
    }

    /**
     * Run another pass over the graph trying to run all nodes possible at the
     * moment. The is a very simple CSP/dependency-resolution problem.
     *
     * @param array $input
     */
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

    /**
     * Check an input array against the SpecGraph.
     *
     * @param array $input
     *
     * @throws CoreException
     * @throws Exceptions\InvalidArgumentException
     * @return SpecResult
     */
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
