<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Testing;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Exceptions\ResolutionException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Closure;
use Mockery;
use Mockery\MockInterface;
use ReflectionClass;
use ReflectionParameter;

/**
 * Class Impersonator.
 *
 * Automatically builds and injects mocks for testing.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing
 */
class Impersonator extends BaseObject
{
    /**
     * List of provided mocks.
     *
     * @var array
     */
    protected $provided;

    /**
     * Construct an instance of an Impersonator.
     */
    public function __construct()
    {
        parent::__construct();

        $this->provided = [];
    }

    /**
     * @return Impersonator
     */
    public static function define()
    {
        return new self();
    }

    /**
     * Attempt to build the provided class.
     *
     * Be aware that complex classes might not be resolved automatically.
     * For example, scalar types are currently not supported.
     *
     * @param mixed $target
     *
     * @throws ResolutionException
     * @return mixed
     */
    public function make($target)
    {
        $arguments = $this->getArgumentTypes($target);

        $resolved = $this->mockArguments($arguments);

        return new $target(...$resolved);
    }

    /**
     * Provide a mock.
     *
     * Here we do some "magic" to attempt to figure out what the mock
     * implements. In order for mock resolution to be fast, relationships
     * between types and mocks are stored on a hash table ($this->provided).
     * This means that if you have objects implementing the same interface or
     * that are instances of the same class, then the last object provided
     * will be the one used.
     *
     * For scenarios where you have two parameters of the same type in the
     * constructor or conflicting interfaces, it is recommended that you build
     * the object manually.
     *
     * @param mixed $mock
     *
     * @throws LackOfCoffeeException
     * @return $this
     */
    public function provide($mock)
    {
        if (is_string($mock) || is_array($mock)) {
            throw new LackOfCoffeeException(
                'A mock cannot be a string or an array.'
            );
        }

        $interfaces = class_implements($mock);
        $parents = class_parents($mock);

        foreach ($interfaces as $interface) {
            $this->provided[$interface] = $mock;
        }

        foreach ($parents as $parent) {
            $this->provided[$parent] = $mock;
        }

        $this->provided[get_class($mock)] = $mock;

        return $this;
    }

    /**
     * A shortcut for building mocks.
     *
     * @param string $type
     * @param Closure $closure
     *
     * @return $this
     */
    public function mock($type, Closure $closure)
    {
        $this->provide(Mockery::mock($type, $closure));

        return $this;
    }

    /**
     * Reflect about a class' constructor parameter types.
     *
     * @param mixed $target
     *
     * @throws LackOfCoffeeException
     * @return ReflectionParameter[]
     */
    protected function getArgumentTypes($target)
    {
        $reflect = new ReflectionClass($target);

        if ($reflect->getConstructor() === null) {
            throw new LackOfCoffeeException(
                'Using an impersonator on a class without a constructor does'
                . ' not make much sense.'
            );
        }

        return $reflect->getConstructor()->getParameters();
    }

    /**
     * Attempt to automatically mock the arguments of a function.
     *
     * @param ReflectionParameter[] $parameters
     *
     * @throws ResolutionException
     * @return array
     */
    protected function mockArguments(array $parameters)
    {
        $resolved = [];

        foreach ($parameters as $parameter) {
            $hint = $parameter->getClass();

            if (is_null($hint)) {
                throw new ResolutionException();
            }

            $mock = $this->resolveMock($hint);

            $resolved[] = $mock;
        }

        return $resolved;
    }

    /**
     * Resolve which mock instance to use.
     *
     * Here we mainly decide whether to use something that was provided to or
     * go ahead an build an empty mock.
     *
     * @param ReflectionClass $type
     *
     * @return MockInterface
     */
    protected function resolveMock(ReflectionClass $type)
    {
        $name = $type->getName();

        if (array_key_exists($name, $this->provided)) {
            return $this->provided[$name];
        }

        return $this->buildMock($type);
    }

    /**
     * Build an empty mock.
     *
     * Override this method if you would like to use a different mocking library
     * or if you would like all your mocks having some properties in common.
     *
     * @param ReflectionClass $type
     *
     * @return MockInterface
     */
    protected function buildMock(ReflectionClass $type)
    {
        return Mockery::mock($type->getName());
    }
}
