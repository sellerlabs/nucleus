<?php

namespace Chromabits\Nucleus\Testing\Interfaces;

/**
 * Interface NameableInterface
 *
 * A simple dummy interface for mocking a class with setters and getters
 *
 * @package Chromabits\Nucleus\Testing\Interfaces
 */
interface NameableInterface
{
    public function setFirstName();

    public function setLastName();

    public function getFirstName();

    public function getLastName();
}
