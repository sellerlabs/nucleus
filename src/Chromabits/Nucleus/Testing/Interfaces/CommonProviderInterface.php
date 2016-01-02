<?php

namespace Chromabits\Nucleus\Testing\Interfaces;

/**
 * Interface CommonProviderInterface.
 *
 * Describes a class that is capable of defining common dependencies to be used
 * with the `impersonatorWithCommon` method in `ImpersonationTrait`.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Testing\Interfaces
 */
interface CommonProviderInterface
{
    /**
     * This method should return a map from class or interface names to a
     * Closure defining a mock or to an array of CallExpectations:
     *
     * Map<String, Either<Array<CallExpectation>, (MockInterface -> void)>>
     *
     * @return mixed
     */
    function getCommonProvisions();
}