<?php

namespace Tests\Chromabits\Nucleus\Support;

use Chromabits\Nucleus\Support\PrimitiveType;
use Chromabits\Nucleus\Testing\TestCase;

/**
 * Class PrimitiveTypeTest
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
            ['STRING', 'INTEGER', 'FLOAT', 'BOOLEAN', 'OBJECT'],
            $result
        );
    }

    public function testGetValues()
    {
        $result = PrimitiveType::getValues();

        $this->assertEquals(
            [
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
