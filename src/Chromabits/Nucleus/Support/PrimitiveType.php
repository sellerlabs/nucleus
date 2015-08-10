<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Chromabits\Nucleus\Support;

/**
 * Class PrimitiveType.
 *
 * Common names for primitive types. PHPUnit and Mockery use these for type
 * assertions and expectation matching.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @deprecated Please use enums in the Meditation namespace.
 * @package Chromabits\Nucleus\Support
 */
class PrimitiveType extends Enum
{
    const COLLECTION = 'array';
    const STRING = 'string';
    const INTEGER = 'int';
    const FLOAT = 'float';
    const BOOLEAN = 'bool';
    const OBJECT = 'object';
}
