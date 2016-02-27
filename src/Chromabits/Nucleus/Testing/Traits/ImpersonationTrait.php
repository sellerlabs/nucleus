<?php

namespace Chromabits\Nucleus\Testing\Traits;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\Testing\Impersonator;
use Chromabits\Nucleus\Testing\Mocking\CallAndThrowExpectation;
use Chromabits\Nucleus\Testing\Mocking\CallExpectation;
use Closure;
use Mockery\MockInterface;

/**
 * Trait ImpersonationTrait.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Traits
 */
trait ImpersonationTrait
{
    /**
     * Shortcut for an Impersonator instance.
     *
     * @return Impersonator
     */
    public function impersonator()
    {
        return Impersonator::define();
    }

    /**
     * @return array<string, array<CallExpectation|Closure>>
     */
    protected function getCommonProvisions()
    {
        return [];
    }

    /**
     * Build an instance of an Impersonator included common dependencies
     * defined in the map returned by getCommonProvisions().
     *
     * @return Impersonator
     * @throws LackOfCoffeeException
     */
    public function impersonatorWithCommon()
    {
        $impersonator = $this->impersonator();

        Std::map(function ($value, $key) use ($impersonator) {
            if (is_array($value) || $value instanceof Closure) {
                $impersonator->mock($key, $value);

                return;
            }

            $impersonator->provide($value);
        }, $this->getCommonProvisions());

        return $impersonator;
    }

    /**
     * Shortcut for constructing an instance of a CallExpectation.
     *
     * @param string $methodName
     * @param array $arguments
     * @param mixed|null $return
     * @param int $times
     *
     * @return CallExpectation
     */
    public function on(
        $methodName,
        array $arguments,
        $return = null,
        $times = 1
    ) {
        return Impersonator::on($methodName, $arguments, $return, $times);
    }

    /**
     * Shortcut for constructing an instance of a CallAndThrowExpectation.
     *
     * @param string $methodName
     * @param array $arguments
     * @param string $exceptionClass
     * @param string $exceptionMessage
     * @param int $exceptionCode
     *
     * @return CallAndThrowExpectation
     */
    public function throwOn(
        $methodName,
        array $arguments,
        $exceptionClass,
        $exceptionMessage = '',
        $exceptionCode = 0
    ) {
        return Impersonator::throwOn(
            $methodName,
            $arguments,
            $exceptionClass,
            $exceptionMessage,
            $exceptionCode
        );
    }

    /**
     * Build a mock from an array of CallExpectations.
     *
     * @param string $type
     * @param CallExpectation[] $expectations
     *
     * @return MockInterface
     */
    public function expectationsToMock($type, $expectations)
    {
        return $this->impersonator()->expectationsToMock($type, $expectations);
    }
}