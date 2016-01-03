<?php

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Meditation\Boa;
use Chromabits\Nucleus\Meditation\TypedSpec;
use Chromabits\Nucleus\Testing\TestCase;
use Chromabits\Nucleus\Validation\Constraints\StringLengthConstraint;

/**
 * Class TypedSpecTest.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class TypedSpecTest extends TestCase
{
    public function testCheck()
    {
        $spec = TypedSpec::define()
            ->setFieldType('first_name', Boa::string())
            ->setFieldType('age', Boa::integer());

        $this->assertTrue($spec->check([
            'first_name' => 'Ed',
            'age' => 23
        ])->passed());
    }

    public function testCheckWithFailures()
    {
        $spec = TypedSpec::define()
            ->setFieldType('first_name', Boa::string())
            ->setFieldType('age', Boa::integer());

        $result = $spec->check([
            'first_name' => 'Ed',
            'age' => 34.7
        ]);

        $this->assertTrue($result->failed());
        $this->assertEquals(['age'], array_keys($result->getFailed()));
    }

    public function testCheckWithConstraints()
    {
        $spec = TypedSpec::define()
            ->setFieldType('first_name', Boa::string())
            ->setFieldConstraints('first_name', new StringLengthConstraint(4))
            ->setFieldType('age', Boa::integer());

        $this->assertTrue($spec->check([
            'first_name' => 'Eduardo',
            'age' => 23
        ])->passed());
    }

    public function testCheckWithFailedConstraints()
    {
        $spec = TypedSpec::define()
            ->setFieldType('first_name', Boa::string())
            ->setFieldConstraints('first_name', new StringLengthConstraint(4))
            ->setFieldType('age', Boa::integer());

        $result = $spec->check([
            'first_name' => 'Ed',
            'age' => 23
        ]);

        $this->assertTrue($result->failed());
        $this->assertEquals(['first_name'], array_keys($result->getFailed()));
    }
}
