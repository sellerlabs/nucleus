<?php

/**
 * Copyright 2015, Eduardo Trujillo
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Nucleus package
 */

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\PrimitiveType;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class PrimitiveTypeTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Support
 */
class PrimitiveTypeTest extends TestCase
{
    public function testGetKeys()
    {
        $result = PrimitiveType::getKeys();

        $this->assertEquals(
            ['COLLECTION', 'STRING', 'INTEGER', 'FLOAT', 'BOOLEAN', 'OBJECT'],
            $result
        );
    }

    public function testGetValues()
    {
        $result = PrimitiveType::getValues();

        $this->assertEquals(
            [
                'COLLECTION' => 'array',
                'STRING' => 'string',
                'INTEGER' => 'int',
                'FLOAT' => 'float',
                'BOOLEAN' => 'bool',
                'OBJECT' => 'object',
            ],
            $result
        );
    }
}
