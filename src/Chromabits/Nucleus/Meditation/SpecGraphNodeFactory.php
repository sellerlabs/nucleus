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

/**
 * Class SpecGraphNodeFactory.
 *
 * A fluent factory for describing and building nodes for a SpecGraph.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecGraphNodeFactory
{
    protected $name;
    protected $dependencies;
    protected $spec;

    /**
     * Construct a new instance of SpecGraphNodeFactory.
     *
     * @param null $name
     */
    public function __construct($name = null)
    {
        $this->name = $name;
        $this->dependencies = [];
        $this->spec = null;
    }

    /**
     * Return whether or not the definition is valid.
     *
     * @return bool
     */
    public function isValid()
    {
        return ($this->name !== null && $this->spec !== null);
    }

    /**
     * Add a dependencies or list of dependencies to this node.
     *
     * @param string[]|string $dependencies
     *
     * @throws LackOfCoffeeException
     * @return $this
     */
    public function dependsOn($dependencies)
    {
        if (is_array($dependencies)) {
            $this->dependencies = array_merge(
                $dependencies,
                $this->dependencies
            );
        } elseif (is_string($dependencies)) {
            $this->dependencies[] = $dependencies;
        } else {
            throw new LackOfCoffeeException(
                'Dependencies can either be an array of strings or a string'
            );
        }

        return $this;
    }

    /**
     * Specify the Spec to use.
     *
     * @param Spec $spec
     *
     * @return $this
     */
    public function withSpec(Spec $spec)
    {
        $this->spec = $spec;

        return $this;
    }

    /**
     * Get the node name.
     *
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the dependencies for this node.
     *
     * @return array
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Get the spec for this node.
     *
     * @return null|Spec
     */
    public function getSpec()
    {
        return $this->spec;
    }
}
