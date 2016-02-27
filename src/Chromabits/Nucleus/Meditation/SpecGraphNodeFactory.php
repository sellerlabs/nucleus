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
use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\BaseObject;

/**
 * Class SpecGraphNodeFactory.
 *
 * A fluent factory for describing and building nodes for a SpecGraph.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Meditation
 */
class SpecGraphNodeFactory extends BaseObject
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var array<string>
     */
    protected $dependencies;

    /**
     * @var Spec|null
     */
    protected $spec;

    /**
     * Construct a new instance of SpecGraphNodeFactory.
     *
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        parent::__construct();

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
     * @return string
     * @throws CoreException
     */
    public function getName()
    {
        if ($this->name === null) {
            throw new CoreException('Incomplete definition');
        }

        return $this->name;
    }

    /**
     * Get the dependencies for this node.
     *
     * @return string[]
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Get the spec for this node.
     *
     * @return Spec
     * @throws CoreException
     */
    public function getSpec()
    {
        if ($this->spec === null) {
            throw new CoreException('Incomplete definition');
        }

        return $this->spec;
    }
}
