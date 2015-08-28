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

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class SpecGraphFactory.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecGraphFactory extends BaseObject
{
    protected $graph;

    /**
     * @var SpecGraphNodeFactory[]
     */
    protected $nodeFactories;

    /**
     * Construct a new instance of a SpecGraphFactory.
     */
    public function __construct()
    {
        parent::__construct();

        $this->graph = new SpecGraph();
        $this->nodeFactories = [];
    }

    /**
     * Add a new node to the graph.
     *
     * @param string $name
     *
     * @return SpecGraphNodeFactory
     */
    public function add($name)
    {
        $factory = new SpecGraphNodeFactory($name);

        $this->nodeFactories[] = $factory;

        return $factory;
    }

    /**
     * Add a new node to the graph. (in one call).
     *
     * @param string $name
     * @param string[] $dependencies
     * @param Spec $spec
     *
     * @throws LackOfCoffeeException
     * @return $this
     */
    public function node($name, array $dependencies, Spec $spec)
    {
        $this->add($name)->dependsOn($dependencies)->withSpec($spec);

        return $this;
    }

    /**
     * Check that the input passes the spec graph.
     *
     * @param array $input
     *
     * @throws LackOfCoffeeException
     * @throws \Chromabits\Nucleus\Exceptions\CoreException
     * @return SpecResult
     */
    public function check(array $input)
    {
        return $this->done()->check($input);
    }

    /**
     * Return the finished SpecGraph.
     *
     * @throws LackOfCoffeeException
     * @return SpecGraph
     */
    public function done()
    {
        $graph = clone $this->graph;

        foreach ($this->nodeFactories as $factory) {
            if (!$factory->isValid()) {
                throw new LackOfCoffeeException(
                    vsprintf(
                        'Definition for the node "%s" is invalid.',
                        [$factory->getName()]
                    )
                );
            }

            $graph->add(
                $factory->getName(),
                $factory->getDependencies(),
                $factory->getSpec()
            );
        }

        return $graph;
    }
}
