<?php

namespace Chromabits\Nucleus\Support;

/**
 * Class PrimitiveType
 *
 * Common names for primitive types. PHPUnit and Mockery use these for type
 * assertions and expectation matching.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Nucleus\Support
 */
class PrimitiveType extends Enum
{
    const STRING = 'string';
    const INTEGER = 'int';
    const FLOAT = 'float';
    const BOOLEAN = 'bool';
    const OBJECT = 'object';
}
