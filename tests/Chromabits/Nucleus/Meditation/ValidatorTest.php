<?php

namespace Tests\Chromabits\Nucleus\Meditation;

use Chromabits\Nucleus\Exceptions\CoreException;
use Chromabits\Nucleus\Meditation\Constraints\ClassTypeConstraint;
use Chromabits\Nucleus\Meditation\Constraints\PrimitiveTypeConstraint;
use Chromabits\Nucleus\Meditation\Primitives\ScalarTypes;
use Chromabits\Nucleus\Meditation\Spec;
use Chromabits\Nucleus\Meditation\Validator;
use Chromabits\Nucleus\Testing\TestCase;
use Exception;
use stdClass;

/**
 * Class ValidatorTest
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Tests\Chromabits\Nucleus\Meditation
 */
class ValidatorTest extends TestCase
{
    public function testCheck()
    {
        $validator = new Validator(new Spec([
            'name' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_STRING),
            'count' => new PrimitiveTypeConstraint(ScalarTypes::SCALAR_INTEGER),
            'exception' => new ClassTypeConstraint(CoreException::class),
            'exception2' => [
                new ClassTypeConstraint(CoreException::class),
                new ClassTypeConstraint(Exception::class)
            ],
            'exception3' => [
                new ClassTypeConstraint(CoreException::class),
                new ClassTypeConstraint(Exception::class)
            ],
        ], [], ['count']), [
            'name' => 'The name should be pretty.',
            'count' => 'The count should be accountable.',
            'exception3' => 'Welp',
        ]);

        $result = $validator->check([
            'name' => 101,
            'exception' => new stdClass(),
            'exception2' => new stdClass(),
            'exception3' => new stdClass(),
        ]);

        $missingClass = 'The value is expected to be an instance of a '
            . 'Chromabits\\Nucleus\\Exceptions\\CoreException.';
        $missingClass2 = 'The value is expected to be an instance of a '
            . 'Exception.';

        $this->assertEquals(
            [
                'name' => 'The name should be pretty.',
                'exception' => [$missingClass],
                'exception2' => [$missingClass, $missingClass2],
                'exception3' => 'Welp',
            ],
            $result->getFailed()
        );
        $this->assertEquals(['count'], $result->getMissing());
    }
}
